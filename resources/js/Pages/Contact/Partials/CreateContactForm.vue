<script setup>
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {nextTick, ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import axios from "axios";

const creatingContact = ref(false);
const nameInput = ref(null);
const emit = defineEmits(['refreshData'])

const form = useForm({
    name: '',
    phone: '',
    address: '',
});

const createContactForm = () => {
    creatingContact.value = true;

    nextTick(() => nameInput.value.focus());
};

const createContact = async () => {
    await axios.post('/api/contacts', {
        name: form.name,
        phone: form.phone,
        address: form.address,
    }).then(response => {
        closeModal();
        form.reset();
    }).catch(error => {
        const errs = error.response.data.errors[0];

        if ('name' in errs) {
            form.setError('name', errs.name[0])
        }

        if ('phone' in errs) {
            form.setError('phone', errs.phone[0])
        }

        if ('address' in errs) {
            form.setError('address', errs.address[0])
        }
    });
};

const closeModal = () => {
    creatingContact.value = false;
    emit('refreshData');
    form.reset();
};
</script>

<template>
    <PrimaryButton @click="createContactForm">Create Contact</PrimaryButton>

    <Modal :show="creatingContact" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create Contact
            </h2>

            <div class="mt-6">
                <InputLabel for="name" value="Name" class="sr-only" />

                <TextInput
                    id="name"
                    ref="nameInput"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Name"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="phone" value="Phone" class="sr-only" />

                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Phone"
                />

                <InputError :message="form.errors.phone" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="address" value="Address" class="sr-only" />

                <TextInput
                    id="address"
                    v-model="form.address"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Address"
                />

                <InputError :message="form.errors.address" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="createContact"
                >
                    Create
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<style scoped>

</style>
