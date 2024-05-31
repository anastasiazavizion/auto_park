<script setup>
const props = defineProps({
    driver:Object
})
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div>Driver</div>
    <div><Link :href="route('drivers.show',props.driver.id)">{{props.driver.name}}, {{props.driver.phone}}</Link></div>
</template>

<style scoped>

</style>
