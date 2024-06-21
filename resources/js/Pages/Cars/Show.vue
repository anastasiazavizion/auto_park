<template>
<div>
    {{$t('Model')}}: {{props.car.model}}
</div>

<div>
    {{$t('Price')}}: {{props.car.price}}
</div>

<div>
    {{$t('Address')}}: {{props.car.park.address}}
</div>

<div>
   <div>
       <v-select v-model="form.driver" :item-props="itemProps" :items="props.car.drivers" label="Driver"></v-select>
   </div>
</div>

<div>
    <form  @submit.prevent="checkout">
        <PrimaryButton type="submit">{{$t('Rent')}}</PrimaryButton>
    </form>
</div>

</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from '@inertiajs/vue3';

const props = defineProps({
    car:Object
})

const form = useForm({
    car_id: props.car.id,
    price: props.car.price,
    model: props.car.model,
    driver:''
});

function checkout(){
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
