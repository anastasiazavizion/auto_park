<script setup>

import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";

import { ChatBubbleLeftRightIcon} from '@heroicons/vue/24/solid'


const props = defineProps({
    type:String,
    comments:Array,
    id:Number
})


const formCommentReply = useForm({
    text: '',
    type:props.type,
    id:props.id,
    parent_id:null
});

const replies = ref(props.comments.map(function (comment){
    return {id:comment.id, show: false}
}));

function repliedIsVisible(id){
    const reply = replies.value.find(reply => reply.id === id);
    if(reply){
        return reply.show;
    }
    return false;
}
function toggleReply(id){
    const reply = replies.value.find(reply => reply.id === id);
    if(reply){
        reply.show = !reply.show;
    }
}

function addReply(id){
    formCommentReply.parent_id = id;
    formCommentReply.post(route('comments.store'), {
        onSuccess: () => {
            formCommentReply.reset();
        },
    });
}


</script>

<template>
    <div class="mt-4">
        <div>
            <div class="border border-slate-300 p-2 mb-4 mt-4" :key="comment.id" v-for="comment in comments">

                <div class="flex justify-between gap-4">
                    <div>{{ comment.text }}</div>
                    <div class="flex gap-4">
                        <div>{{ comment.user.name }}, {{ comment.created_at }}</div>
                        <div>
                            <ChatBubbleLeftRightIcon :title="$t('Reply')" class="w-6 cursor-pointer" @click="toggleReply(comment.id)" />
                        </div>
                    </div>
                </div>


                <div v-if="repliedIsVisible(comment.id)">
                    <form @submit.prevent="addReply(comment.id)">
                        <div>
                            <InputLabel for="text" :value="$t('Reply text')" />

                            <TextInput
                                id="text"
                                ref="text"
                                v-model="formCommentReply.text"
                                type="text"
                                class="mt-1 block w-full"
                            />

                            <InputError :message="formCommentReply.text.errors" />
                        </div>

                        <div>
                            <PrimaryButton class="text-center" type="submit">{{ $t('Save reply') }}</PrimaryButton>
                        </div>
                    </form>
                </div>

                <div v-if="comment.children.length > 0">
                    <Comments :comments="comment.children" :id="id" :type="type"></Comments>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
