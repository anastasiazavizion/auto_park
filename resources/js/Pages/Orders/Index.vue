<script setup>
import Status from "@/Pages/Orders/Partials/Status.vue";
import Price from "@/Components/Price.vue";
import {Link} from "@inertiajs/vue3";
import OrderPayButton from "@/Pages/Orders/Partials/OrderPayButton.vue";
const props = defineProps({
    orders:Array
})

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
            <td><Link :href="route('orders.show', order.id)">{{order.id}}</Link></td>
            <td>{{order.created_at}}</td>
            <td><Status :status="order.status"/></td>
            <td><Price :price="order.total"/></td>
            <td>
                <OrderPayButton :order="order"/>
            </td>
        </tr>
        </tbody>
    </table>

</template>

<style scoped>

</style>
