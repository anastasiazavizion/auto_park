<script setup>
const props = defineProps({
    name:String
})
</script>


<template>
    <h1>Thanks {{props.name}} for your order!</h1>
    <p>
        If you have any questions, please email
        <a href="mailto:orders@example.com">orders@example.com</a>.
    </p>
</template>

<style scoped>

</style>
