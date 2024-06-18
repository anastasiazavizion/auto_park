<script setup>

const props = defineProps({
    driver:Object
})
import DriverDetails from "@/Pages/Drivers/Partials/DriverDetails.vue";

</script>

<template>
    <DriverDetails :driver="props.driver"/>
</template>
