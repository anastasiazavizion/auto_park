<script setup>
import Status from "@/Pages/Orders/Partials/Status.vue";
import Price from "@/Components/Price.vue";
import {Link} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import OrderPayButton from "@/Pages/Orders/Partials/OrderPayButton.vue";
import DetailCard from "@/Components/DetailCard.vue";

const props = defineProps({
    order:Object
})
</script>

<template>
<Header>Order #{{order.id}}</Header>
<Card>
    <DetailCard label="Date">{{order.created_at}}</DetailCard>
    <DetailCard label="Total"><Price :price="order.total"/></DetailCard>
    <DetailCard label="Status"><Status :status="order.status"/></DetailCard>
    <DetailCard label="Car"><Link :href="route('cars.show', order.car)">{{order.car.model}}</Link></DetailCard>
    <DetailCard label="Driver"><Link :href="route('drivers.show', order.driver)">{{order.driver.name}}</Link></DetailCard>
    <OrderPayButton :order="order"/>
</Card>
</template>
