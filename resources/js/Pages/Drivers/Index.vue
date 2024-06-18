<script setup>
import DriverDetails from "@/Pages/Drivers/Partials/DriverDetails.vue";
const props = defineProps({
    drivers:Array
})
</script>

<template>
    <div :v-key="driver.id" v-for="driver in props.drivers">
       <DriverDetails :driver="driver"/>
    </div>
</template>
