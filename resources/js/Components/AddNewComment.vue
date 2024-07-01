<script setup>
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    type:String,
    id:Number
})

const formComment = useForm({
    text: '',
    type:props.type,
    id:props.id
});

function addComment(){
    formComment.post(route('comments.store'), {
        onSuccess: () => {
            formComment.reset();
        },
    });
}

</script>

<template>
    <div class="mt-4">
        <div>Comments</div>
        <div>
            <form @submit.prevent="addComment">
                <div>
                    <InputLabel for="text" :value="$t('Text')" />

                    <TextInput
                        id="text"
                        ref="text"
                        v-model="formComment.text"
                        type="text"
                        class="mt-1 block w-full"
                    />

                    <InputError :message="formComment.text.errors"/>
                </div>

                <div>
                    <PrimaryButton class="text-center"  type="submit">{{$t('Add comment')}}</PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
