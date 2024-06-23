<script setup>
defineProps({
    label:String
})
</script>

<template>
    <div class="flex mb-2">
        <div class="w-1/2 border rounded-l-md   border-r-0 border-slate-400 p-1 font-bold">{{label}}</div>
        <div class="w-1/2 border rounded-r-md border-slate-400 p-1"><slot></slot></div>
    </div>
</template>

<style scoped>

</style>
