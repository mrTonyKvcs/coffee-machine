<template>
    <div class="container bg-coffee pt-3 pb-3 mt-5 bg-light">

        <div class="row bg-claret mb-5 shadow-sm">
            <div class="col-md-12">
                <h1 class=" text-white text-center text-uppercase pt-5 pb-5 mb-0">{{ machineName }}</h1>
            </div>
        </div>

        <div v-if="machine.machine_status" class="row">
            <div class="col-md-12">
                <div class="alert alert-danger text-center text-uppercase" role="alert">
                    Jelenleg ez a gépünk nem üzemel!
                </div>
            </div>
        </div>

        <div v-if="!machine.machine_status" class="row">
            <div v-if="orderErrorMsg" class="col-md-12">
                <div class="alert alert-warning text-center text-uppercase" role="alert">
                    {{ orderErrorMsg }}
                </div>
            </div>
            <div v-if="!buying && products.length > 0" class="col-md-12">
                <div class="alert alert-light text-center text-uppercase" role="alert">
                    {{ chooseProductMsg }}
                </div>
            </div>
            <div v-if="products.length === 0" class="col-md-12">
                <div class="alert alert-danger text-center text-uppercase" role="alert">
                    {{ errorProductMsg }}
                </div>
            </div>
            <div v-if="products != null" v-for="product in products" class="col-md-12">
                <div @click="orderProduct(product.id, product.name)" class="c-product border border-secondary shadow-sm">
                    <div class="c-product__overlay">
                        <h2 class="text-center text-uppercase pt-5 pl-5 pr-5 pb-5">{{ product.name }}</h2>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="buying" class="row justify-content-center pb-5">
            <div class="col-md-8">
                <svg version="1.1" x="0px" y="0px" width="100%" height="auto" viewBox="0 0 501 501" style="enable-background:new 0 0 501 501;" xml:space="preserve">
                    <svg:style type="text/css" >
                        .bg{fill:#fff;}
                        .steam{stroke:#FFF; fill: none; stroke-width: 2px;}
                        .cup{fill:#FFF;stroke:#000;stroke-width:2;stroke-miterlimit:10;}
                        .liquid{fill:#351F02;stroke:#351F02;stroke-miterlimit:10;}
                        .sleeve{fill:#821200;}
                        .lid{fill:#821200;stroke:#821200;stroke-width:2;stroke-miterlimit:10;}
                    </svg:style>
                        <defs>
                        <mask id="liquidMasked">
                        <path fill="#FFF" d="M294.3,377.1c-32.8,9.4-68.2,9.3-101-0.2c-7.1-60.7-14.1-119.7-21.5-175.6c48.3,0,96.5,0,144.8,0 C309,257.2,301.7,316.3,294.3,377.1z"/
                        </mask>
                        </defs>
                        <rect x="0.5" y="0.5" class="bg" width="500" height="500"/>
                        <path class="cup" d="M301.4,382.2c-37.4,10.4-77.9,10.3-115.2-0.3c-8.1-66.7-16.1-131.6-24.5-193c55.1,0,110.1,0,165.2,0
                        C318.1,250.3,309.8,315.3,301.4,382.2z"/>
                        <g id="coffeeMasked" mask="url(#liquidMasked)">
                        <path class="liquid" d="M293.8,376.6c-32.8,9.4-68.2,9.3-101-0.2c-7.1-60.7-14.1-119.7-21.5-175.6c0,0,12-7.1,31.3-0.4
                        c29.8,10.3,32.7-0.2,48.7-0.2c27.4,0,29.2,8.8,44.7,1.3c14.7-7.1,20.2-0.7,20.2-0.7C308.5,<t_CO>.7,301.2,315.8,293.8,376.6z"/>
                        </g>
                        <g class="steam"> 
                        <path d="M308.5,169c0,0-16.5-17-13-32.5s22-5.5,13.5,6c-7.9,10.6-23.8-6.9-12-21.8c11.5-14.5,10.7-22,10-24.8
                        c-5-18.4-18.6-5.8-12.6-1.1c9.4,7.1,15.2-16.5,13.2-24.5"/>
                        </g>
                        <path class="sleeve" d="M310.2,334.2c-44,5.4-88.4,5.4-132.4,0c-3.2-27.8-6.4-55.7-9.6-83.6c50.4,7.2,101.6,7.2,152,0
                        C316.9,278.4,313.5,306.3,310.2,334.2z"/>
                        <path class="lid" d="M337.2,187v13.8c0,0-15.8,3.7-92,3.7s-92-3.7-92-3.7V187c0-1.8,1.4-3.2,3.2-3.2h5.8v-11.5
                        c0-3.6,2.9-6.5,6.5-6.5h131.8l3.4,2.2c1.1,0.7,2.5,0.7,3.7,0l3.7-2.2h10.9c3.3,0,6.1,2.7,6.1,6.1v11.9h5.8
                        C335.8,183.8,337.2,185.2,337.2,187z"/>
                </svg>
            </div>
            <div class="col-md-8 mt-3">
                <div class="alert alert-success text-center text-uppercase" role="alert">
                    {{ orderMsg }}
                </div>
            </div>
            <button @click="finishedOrder" class="btn btn-claret col-md-8 rounded-0 p-3">befejezés</button>
        </div>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                buying: false,
                machine: [],
                orderMsg: "",
                orderErrorMsg: "",
                chooseProductMsg: "Válassz egy terméket!",
                errorProductMsg: "Jelenleg egyik termékünk sem rendelhető!",
            }
        },

        created () {
            this.getMachine()
        },

        computed: {
            machineName() {
                return this.machine.machine_name
            },
            products() {
                return this.machine.products
            }
        },

        methods: {
            getMachine () {
                axios.get('/api/machines/1')
                    .then(response => {
                        this.machine = response.data

                        if (this.products.lenth > 0) {
                            this.errorProductMsg = ""
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
            },
            orderProduct (id, name) {
                if (!this.buying) {
                    axios.post('/api/order-product/1/' + id)
                        .then(() => {
                            this.orderMsg = 'Elkészült a(z) ' + name + ', óvatosan mert forró! Egészségedre!'
                            this.buying = true
                            this.getMachine()
                        })
                        .catch(error => {
                            console.log(error)
                            this.errored = true
                        })
                }
                else {
                    this.orderErrorMsg = "Kérlek fejezd be az előző vásárlást mielőtt új terméket választasz!" 
                }
            },
            finishedOrder () {
                this.buying = !this.buying
                this.orderErrorMsg = ""
                this.products
            }
        }
    }
</script>
