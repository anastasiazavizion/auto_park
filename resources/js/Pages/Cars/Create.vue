<template>
<Card>
 <Header>{{$t('Add new car')}}</Header>

 <div>
     <form @submit.prevent="saveCar" class="flex flex-col w-full gap-4">

         <div>
             <InputLabel for="model" :value="$t('Model')" />
             <TextInput
                 id="model"
                 ref="model"
                 v-model="form.model"
                 type="text"
                 class="mt-1 block w-full"
             />
             <InputError :message="form.model.errors"/>
         </div>

         <div>
             <InputLabel for="price" :value="$t('Price')" />

             <TextInput
                 id="price"
                 ref="price"
                 v-model="form.price"
                 type="text"
                 class="mt-1 block w-full"
             />

             <InputError :message="form.price.errors"/>
         </div>


         <div>
             <InputLabel for="drivers" :value="$t('Drivers')" />

             <select multiple v-model="form.drivers">
                 <option :value="driver.id" :key="driver.id" v-for="driver in drivers">
                     {{driver.name}}
                 </option>
             </select>
             <InputError :message="form.drivers.errors"/>
         </div>


         <div>
             <InputLabel for="park" :value="$t('Park')" />

             <select v-model="form.park">
                 <option :value="park.id" :key="park.id" v-for="park in parks">
                     {{park.address}}
                 </option>
             </select>
             <InputError :message="form.park.errors"/>
         </div>

         <div>
             <ImagePreview :images="[]" v-model="form.images"></ImagePreview>
             <pre>
                 {{form.images}}
             </pre>
         </div>

         <div>
             <PrimaryButton class="text-center"  type="submit">{{$t('Add')}}</PrimaryButton>
         </div>

     </form>
 </div>



</Card>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from '@inertiajs/vue3';
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import ImagePreview from "@/Pages/Cars/Partials/ImagePreview.vue";

defineProps({
    parks:Array,
    drivers:Array
})
const form = useForm({
    price: '',
    model: '',
    park:[],
    drivers:[],
    images:[]
});

function saveCar(){
    form.post(route('cars.store'), {
        onSuccess: (page) => {
        },
    });
}

</script>
