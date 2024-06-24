<script setup>
import Price from "@/Components/Price.vue";

const props = defineProps({
    countCars:Array,
    driversCount:Array,
    latestPaidOrders:Array,
    ordersNumber:Number,
    ordersTotalIncome:String,
    paidOrders:Number,

})

import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";
import DoughnutChart from "../../Charts/DoughnutChart.vue";
import {Link} from '@inertiajs/vue3';
</script>

<template>
<Header>Dashboard</Header>
<Card>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        <div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div class="flex flex-col bg-white border border-slate-300 py-3 px-5 text-xl rounded-md shadow-md justify-center text-center">
                    <label>{{$t('Orders number')}}</label>
                    <span class="text-3xl">{{ordersNumber}}</span>
                </div>

                <div class="flex flex-col bg-white border border-slate-300 py-3 px-5 text-xl rounded-md shadow-md justify-center text-center">
                    <label>{{$t('Total income')}}</label>
                    <span class="text-3xl"><Price>{{ordersTotalIncome}}</Price></span>
                </div>

                   <div class="flex flex-col bg-white border border-slate-300 py-3 px-5 text-xl rounded-md shadow-md justify-center text-center">
                       <label>{{$t('Paid orders')}}</label>
                       <span class="text-3xl">{{paidOrders}}</span>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                <div class="flex flex-col bg-white border border-slate-300 py-3 px-5 text-xl rounded-md shadow-md justify-center text-center">
                    <DoughnutChart :data="countCars"></DoughnutChart>
                </div>

                <div class="flex flex-col bg-white border border-slate-300 py-3 px-5 text-xl rounded-md shadow-md justify-center text-center">
                    <DoughnutChart :data="driversCount"></DoughnutChart>
                </div>

            </div>
        </div>

        <div class="flex flex-col bg-white border border-slate-300 py-3 px-5  rounded-md shadow-md">

            <div class="mb-4" v-for="order in latestPaidOrders">
                <div><Link class="text-violet-500" :href="route('orders.show', order.id)">Order #{{order.id}}</Link>, <Link :href="route('cars.show', order.car)">{{order.car.model}}</Link>, <Price>{{order.total}}</Price></div>
                <div class="flex text-sm gap-4">
                    <div class="w-3/4">{{order.user.name}}</div>
                    <div>{{order.created_at_human}}</div>
                </div>
            </div>

        </div>

    </div>

</Card>
</template>

<style scoped>

</style>
