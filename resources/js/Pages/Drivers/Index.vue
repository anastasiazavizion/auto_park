<script setup>
import Card from "@/Components/Card.vue";
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    cars:Array
})
</script>

<template>
    <div :v-key="car.id" v-for="car in cars">
        <Card>
            <div class="flex justify-between">
                <div class="font-bold">Model</div>
                <div><Link :href="route('cars.show',car.id)">{{car.model}}</Link></div>
            </div>
            <div class="flex justify-between">
                <div>Park</div>
                <div>{{car.park.address}}</div>
            </div>
        </Card>
    </div>

</template>

<style scoped>

</style>
