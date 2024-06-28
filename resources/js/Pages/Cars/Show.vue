<template>
<Card>
 <Header>{{props.car.model}}</Header>

<div class="flex gap-4">

 <div class="md:w-1/4">
     <div class="w-full">
         <img class="rounded-md w-80 h-80" :src="activeImageUrl" :alt="car.model">
     </div>
     <div class="flex gap-4 mt-4">
         <div
             v-for="image in car.images"
             :key="image.id"
             @click="activateImage(image.url)"
         >
             <img class="rounded-md w-20 h-20 cursor-pointer" :src="image.url" :alt="car.model">
         </div>
     </div>
 </div>

<div class="md:w-3/4">
         <DetailCard :class="[form.errors.price ? 'errorInput' : '']" :label="$t('Price/Hour')">{{props.car.price}}</DetailCard>
         <Error v-if="form.errors.price">{{form.errors.price}}</Error>
         <DetailCard :class="[form.errors.address ? 'errorInput' : '']" :label="$t('Address')">{{props.car.park.address}}</DetailCard>
         <Error v-if="form.errors.address">{{form.errors.address}}</Error>

         <DetailCard :class="[form.errors.driver ? 'errorInput' :'']" :label="$t('Driver')">
             <select class="w-full" v-model="form.driver">
                 <option value="">{{$t('Select')}}</option>
                 <option :key="driver.id" :value="driver.id" v-for="driver in props.car.drivers">{{driver.name}}</option>
             </select>
         </DetailCard>
         <Error v-if="form.errors.driver">{{form.errors.driver}}</Error>

         <DetailCard :class="[form.errors.start ? 'errorInput':'']"  :label="$t('Start date')"><VueDatePicker v-model="form.start" /> </DetailCard>
         <Error v-if="form.errors.start">{{form.errors.start}}</Error>

         <DetailCard :class="[form.errors.finish ? 'errorInput':'']"  :label="$t('Finish date')"><VueDatePicker v-model="form.finish" /> </DetailCard>
         <Error v-if="form.errors.finish">{{form.errors.finish}}</Error>

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
import Error from "@/Components/Error.vue";
import {computed, ref} from "vue";

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


const activeImage = ref(0);

const activeImageUrl = ref(props.car.image);

function activateImage(url) {
    activeImageUrl.value = url;
}
</script>
