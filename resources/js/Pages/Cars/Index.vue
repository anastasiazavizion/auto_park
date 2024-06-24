<script setup>
import Card from "@/Components/Card.vue";
import { Link } from '@inertiajs/vue3';
import Price from "@/Components/Price.vue";
const props = defineProps({
    cars:Array
})
</script>
<template>
    <div :v-key="car.id" v-for="car in cars">
        <Card>
            <div class="grid grid-cols-3">
                <div class="flex flex-col">
                    <div class="font-bold"><Link :href="route('cars.show',car.id)">{{car.model}}</Link></div>
                    <div><img class="w-64" :src="car.image" :alt="car.model"></div>
                </div>
                <div class="flex flex-col col-span-2">
                    <div><Price>{{car.price}}/{{$t('Hour')}}</Price></div>
                    <div>{{car.park.address}}</div>
                </div>
            </div>
        </Card>
    </div>
</template>
