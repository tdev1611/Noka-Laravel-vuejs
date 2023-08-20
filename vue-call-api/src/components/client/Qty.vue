<template>
    <div class="col-md-4 col-6 mb-3">
        <label class="mb-2 d-block">Quantity</label>
        <div class="input-group mb-3" style="width: 170px;">
            <button @click="decreament()" class="btn btn-white border border-secondary px-3" type="button"
                id="button-addon1" data-mdb-ripple-color="dark">
                <i class="fas fa-minus"></i>
            </button>
            <input type="text" id="num_order" name="num_order" class="form-control text-center border border-secondary"
                v-model="currentVal" aria-label="Example text with button addon" />
            <button @click="increment()" class="btn btn-white border border-secondary px-3" type="button" id="button-addon2"
                data-mdb-ripple-color="dark">
                <i class="fas fa-plus"></i>
            </button>

        </div>
    </div>
</template>


<script>

export default {

    data() {
        return {
            currentVal: 1,
        }
    },
    methods: {
        increment() {
            this.currentVal++;
            // console.log(this.currentVal);
            this.$emit('input', this.currentVal);
        },
        decreament() {
            if (this.currentVal > 1) {
                this.currentVal--;
                this.$emit('input', this.currentVal);
            }
        }
    },
};

</script>