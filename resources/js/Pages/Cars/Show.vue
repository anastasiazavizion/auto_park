<template>
<Card>
 <Header>{{props.car.model}}</Header>

 <div class="flex w-full gap-4">
     <div class="w-1/2"><img :src="props.car.image" :alt="props.car.model"></div>
     <div class="w-1/2">
         <DetailCard :label="$t('Price/Hour')">{{props.car.price}}</DetailCard>
         <DetailCard :label="$t('Address')">{{props.car.park.address}}</DetailCard>
         <DetailCard :label="$t('Driver')">
             <select class="w-full" v-model="form.driver">
                 <option value="">{{$t('Select')}}</option>
                 <option :key="driver.id" :value="driver.id" v-for="driver in props.car.drivers">{{driver.name}}</option>
             </select>
         </DetailCard>

         <DetailCard :label="$t('Start date')"><VueDatePicker v-model="form.start" /> </DetailCard>

         <DetailCard :label="$t('Finish date')"><VueDatePicker v-model="form.finish" /> </DetailCard>
     </div>

 </div>

<div class="mt-4 text-center">
    <form  @submit.prevent="checkout">
        <PrimaryButton class="w-1/2 text-center"  type="submit">{{$t('Rent')}}</PrimaryButton>
    </form>
</div>


</Card>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from '@inertiajs/vue3';
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";
import DetailCard from "@/Components/DetailCard.vue";

const props = defineProps({
    car:Object
})

const form = useForm({
    car_id: props.car.id,
    price: props.car.price,
    model: props.car.model,
    start: '',
    finish: '',
    driver:''
});

function checkout(){
    form.post(route('order.checkout'), {
        onSuccess: (page) => {
        },
    });
}


</script>
