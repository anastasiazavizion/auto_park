<script setup>

import {Link} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";

const props = defineProps({
    driver:Object
})
</script>

<template>
    <Card>
        <div>Name = {{props.driver.name}}</div>
        <div>Phone = {{props.driver.phone}}</div>
        <div>Driver cars:</div>
        <div v-for="car in props.driver.cars">
            <Link :href="route('cars.show',car.id)">{{car.model}}</Link>
        </div>
    </Card>
</template>
