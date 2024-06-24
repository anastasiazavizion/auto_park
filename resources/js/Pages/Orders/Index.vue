<script setup>
import Status from "@/Pages/Orders/Partials/Status.vue";
import Price from "@/Components/Price.vue";
import {Link} from "@inertiajs/vue3";
import OrderPayButton from "@/Pages/Orders/Partials/OrderPayButton.vue";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
const props = defineProps({
    orders:Array
})
</script>

<template>
    <Header>{{$t('Orders')}}</Header>
    <Card>
        <table>
            <thead>
            <tr>
                <th>{{$t('Order')}} #</th>
                <th>{{$t('Date')}}</th>
                <th>{{$t('Status')}}</th>
                <th>{{$t('Total')}}</th>
                <th>{{$t('Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="order in props.orders" :key="order.id">
                <td><Link :href="route('orders.show', order.id)">{{order.id}}</Link></td>
                <td>{{order.created_at}}</td>
                <td><Status :status="order.status"/></td>
                <td><Price>{{order.total}}</Price></td>
                <td>
                    <OrderPayButton :order="order"/>
                </td>
            </tr>
            </tbody>
        </table>
    </Card>
</template>
