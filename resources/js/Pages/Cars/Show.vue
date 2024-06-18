<script setup>
import DriverInfo from "@/Pages/Drivers/Partials/DriverInfo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";

const props = defineProps({
    car:Object
})

const show = ref(false);

function closeModal(){
    console.log('closeModal');
    show.value = false;

}
</script>

<template>
<div>
    Model: {{props.car.model}}
</div>

<div>
    Price: {{props.car.price}}
</div>

<div>
    Address: {{props.car.park.address}}
</div>

<div>
    Drivers:
    <div v-for="driver in props.car.drivers">
        <DriverInfo :driver="driver"/>
    </div>
</div>

<div>
      <PrimaryButton @click="show = true">RENT</PrimaryButton>
</div>

<Modal @close="closeModal" :show="show" :closeable="true">
    <div>Stripe payment.....</div>
</Modal>


</template>

<style scoped>

</style>
