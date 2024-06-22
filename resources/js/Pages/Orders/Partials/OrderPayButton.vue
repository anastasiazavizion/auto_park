<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    order:Object
})
</script>

<template>
    <div v-if="!order.is_paid"><Link as="button" method="post" :href="route('order.checkoutOrder', order.id)">Pay</Link></div>
</template>
