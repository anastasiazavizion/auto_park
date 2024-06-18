<template>
<div>
    Model: {{props.car.model}}
</div>

<div>
    Price: {{props.car.price}}
</div>

<div>
    Address: {{props.car.park.address}}
</div>

<div>
   <div>

       <v-select v-model="form.driver" :item-props="itemProps" :items="props.car.drivers" label="Driver"></v-select>


   </div>
</div>

<div>
    <form  @submit.prevent="checkout">
        <PrimaryButton type="submit">Rent</PrimaryButton>
    </form>
</div>

<Modal @close="closeModal" :show="show" :closeable="true">
    <div>Stripe payment.....</div>
</Modal>


</template>

<script setup>
import DriverInfo from "@/Pages/Drivers/Partials/DriverInfo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import { Link ,useForm} from '@inertiajs/vue3';

const props = defineProps({
    car:Object
})
const selectedDriverId = ref(null);
const show = ref(false);

function closeModal(){
    console.log('closeModal');
    show.value = false;
}

const form = useForm({
    car_id: props.car.id,
    price: props.car.price,
    model: props.car.model,
    driver:''
});

function checkout(){

    console.log(form.driver);

    form.post(route('order.checkout'), {
        onSuccess: (page) => {

        },
    });
}

function itemProps(item) {
    return {
        title: item.name,
    }
}

</script>
