<script setup>
import Comments from "@/Components/Comments.vue";

const props = defineProps({
    driver:Object
})
import DriverDetails from "@/Pages/Drivers/Partials/DriverDetails.vue";
</script>

<template>
    <DriverDetails :driver="props.driver"/>

    <Comments :comments="driver.comments" :id="driver.id" type="App\Models\Driver"></Comments>

</template>
