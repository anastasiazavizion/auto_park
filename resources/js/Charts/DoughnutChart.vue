<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Doughnut } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
   data:Array
})

function dynamicColors() {
    const r = Math.floor(Math.random() * 255);
    const g = Math.floor(Math.random() * 255);
    const b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
}

const dataChart = {
    labels: props.data.map(a => a.name),
    datasets: [
        {   backgroundColor: props.data.map( a => dynamicColors()),
            data: props.data.map(a => a.count),
        }
    ]
}

const options = {
    responsive: true,
    maintainAspectRatio: false
}
</script>

<template>
    <Doughnut :data="dataChart" :options="options" />
</template>
