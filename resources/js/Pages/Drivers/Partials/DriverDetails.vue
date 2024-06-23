<script setup>
import {Link} from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import DetailCard from "@/Components/DetailCard.vue";
const props = defineProps({
    driver:Object
})
</script>

<template>
    <Card>
        <DetailCard :label="$t('Name')">{{props.driver.name}}</DetailCard>
        <DetailCard :label="$t('Phone')">{{props.driver.phone}}</DetailCard>
        <DetailCard :label="$t('Driver cars')">
            <div v-for="car in props.driver.cars">
                <div class="border-b border-slate-400 mb-2"><Link :href="route('cars.show',car.id)">{{car.model}}</Link></div>
            </div>
        </DetailCard>
    </Card>
</template>
