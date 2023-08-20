<template>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css"
        integrity="sha512-/RUbtHakVMJrg1ILtwvDIceb/cDkk97rWKvfnFSTOmNbytCyEylutDqeEr9adIBye3suD3RfcsXLOLBqYRW4gw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="container" style="padding-top: 20px;">
        <div v-if="showNotification" id="notificationAjax">
            <span id="chi-notificationAjax">
                <p v-if="messages">{{ messages }}</p>
            </span>
        </div>

        <form @submit.prevent="addToCart">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center show-pic">
                        <a class="rounded-4" data-type="image" id="image-container">
                            <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit"
                                :src="productImage" :title="product.name" />
                        </a>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <p class="border mx-1 rounded-2 item-thumb " data-type="image" v-for="item in listImage"
                            :key="item.id">
                            <img width="60" height="60" class="rounded-2" :src="item.url" />
                        </p>
                    </div>
                    <!-- thumbs-wrap.// -->
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            {{ product.name }}
                        </h4>
                        <div class="d-flex flex-row my-2">

                        </div>
                        <div class="mb-3">
                            <span class="h5">$ {{ product.price }} </span>
                            <span class="text-muted">/per box</span>
                        </div>
                        <p>
                            {{ product.desc }}
                        </p>
                        <div class="row">
                            <dt class="col-3">Type:</dt>
                            <dd class="col-9"> {{ product.desc }}</dd>
                            <div class="col-md-4 col-6">
                                <label class="mb-2" for="sizes">Sizes</label>
                                <select class="form-select border border-secondary  w-50" style="height: 35px;" name="sizes"
                                    id="sizes" v-model="selectedSize">
                                    <option v-for="size in product.sizes" :key="size.id" :value="size.name">
                                        {{ size.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <hr />

                        <div class="row mb-4">
                            <div class="col-md-4 col-6">
                                <label class="mb-2" for="colors">Colors</label>
                                <select class="form-select border border-secondary" style="height: 35px;" name="colors"
                                    id="colors" v-model="selectedColor">
                                    <option v-for="color in product.colors" :key="color.id" :value="color.name">
                                        {{ color.name }}
                                    </option>
                                </select>
                            </div>
                            <!-- qty -->
                            <qty-selector v-model="qty" @input="updateQty" />
                        </div>
                        <button type="submit" id="add-cart" class="btn btn-primary shadow-0">
                            <i class="me-1 fa fa-shopping-basket"></i>
                            Add to cart </button>
                    </div>
                </main>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import QtySelector from "../../components/client/Qty.vue"
export default {
    components: {
        QtySelector
    },

    data() {
        return {
            product: [],
            productImage: null,
            listImage: [],
            selectedSize: 'XS',
            selectedColor: 'Blue',
            qty: 1,

            showNotification: false,
            messages: '',
        }
    },
    mounted() {
        this.fetchProductDetails();
    },
    methods: {
        fetchProductDetails() {
            const slug = this.$route.params.slug;
            axios.get(`http://127.0.0.1:8000/api/san-pham/${slug}.html`)
                .then(response => {
                    this.product = response.data.data.product;
                    // console.log(this.product);
                    const baseUrl = "http://localhost:5173";
                    // image
                    const image = this.product.image
                    const imageUrl = image.replace("san-pham", "");
                    this.productImage = `${baseUrl}/${imageUrl}`;
                    // listImg
                    // console.log(JSON.parse(this.product.list_image));
                    this.listImage = JSON.parse(this.product.list_image).map((imagePath) => {
                        return {
                            url: `${baseUrl}/${imagePath}`,
                        };
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi load sản phẩm:', error);
                });
        },
        updateQty(newQty) {
            this.qty = newQty;
        },
        addToCart() {
            const productData = {
                id: this.product.id,
                qty: this.qty,
                color: this.selectedColor,
                size: this.selectedSize,
            }
            // console.log(productData.qty);
            axios.post('http://127.0.0.1:8000/api/gio-hang/add', productData)
                .then(response => {
                    console.log(response.data);
                    if (response.data.status == 'success') {
                        this.messages = response.data.messages
                        //notify
                        this.showNotification = true
                        setTimeout(() => {
                            this.showNotification = false;
                        }, 3000);
                    } else {
                        this.messages = response.data.messages
                        this.showNotification = true
                        setTimeout(() => {
                            this.showNotification = false;
                        }, 3000);
                    }
                })


        }


    },
}



</script>


<style>
.icon-hover:hover {
    border-color: #3b71ca !important;
    background-color: white !important;
    color: #3b71ca !important;
}

.icon-hover:hover i {
    color: #3b71ca !important;
}

.item-thumb {
    cursor: pointer;
}

#notificationAjax {
    position: fixed;
    top: 10px;
    right: 10px;
    padding: 2.5rem 1.25rem;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    font-size: 1.0625rem;
    min-width: 18.75rem;
    z-index: 9999;
    border-radius: 15px;
    opacity: 0.8;
}
</style>  
 