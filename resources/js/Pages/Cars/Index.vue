<script setup>
import Card from "@/Components/Card.vue";
import {Link, usePage} from '@inertiajs/vue3';
import Price from "@/Components/Price.vue";
import Pagination from "@/Components/Pagination.vue";
import {computed} from "vue";
import { PencilIcon, XMarkIcon} from '@heroicons/vue/24/solid'
const props = defineProps({
    cars:Object
})

let page = usePage()
const isAdmin = computed(() => page.props.auth.isAdmin)
</script>
<template>

    <Card v-if="isAdmin">
        <Link class="btn" :href="route('cars.create')">{{$t('Add new car')}}</Link>
    </Card>
    <div :v-key="car.id" v-for="car in cars.data">
        <Card>
            <div class="grid grid-cols-3">
                <div class="flex flex-col">
                    <div class="font-bold"><Link :href="route('cars.show',car.id)">{{car.model}}</Link></div>
                    <div><img class="w-64" :src="car.image" :alt="car.model"></div>
                </div>
                <div class="flex flex-col col-span-2 relative">
                    <div><Price>{{car.price}}/{{$t('Hour')}}</Price></div>
                    <div>{{car.park.address}}</div>
                    <div class="absolute right-0 top-0 flex gap-2"  v-if="isAdmin">
                        <Link :title="$t('Edit car')"  :href="route('cars.edit', car.id)" v-if="isAdmin"><PencilIcon class="w-6"></PencilIcon></Link>
                        <Link as="button" method="DELETE" :title="$t('Delete car')" :href="route('cars.destroy', car.id)" v-if="isAdmin"><XMarkIcon class="w-6"></XMarkIcon></Link>
                    </div>
                </div>
            </div>
        </Card>
    </div>
    <Pagination :data="cars.links"/>
</template>
