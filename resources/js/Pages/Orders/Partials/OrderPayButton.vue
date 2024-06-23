<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    order:Object
})
</script>

<template>
    <div v-if="!order.is_paid"><Link as="button" class="w-full items-center px-4 py-2 bg-violet-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 text-center" method="post" :href="route('order.checkoutOrder', order.id)">Pay</Link></div>
</template>
