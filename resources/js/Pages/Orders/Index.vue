<script setup>
import Status from "@/Pages/Orders/Partials/Status.vue";
import Price from "@/Components/Price.vue";
import {Link} from "@inertiajs/vue3";
const props = defineProps({
    orders:Array
})

console.log(props.orders);

</script>

<template>

    <table>
        <thead>
        <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="order in props.orders" :key="order.id">
            <td>{{order.id}}</td>
            <td>{{order.created_at}}</td>
            <td><Status :status="order.status"/></td>
            <td><Price :price="order.total"/></td>
            <td>
                <div v-if="!order.is_paid"><Link as="button" method="post" :href="route('order.checkoutOrder', order.id)">Pay</Link></div>
            </td>
        </tr>
        </tbody>
    </table>

</template>

<style scoped>

</style>
