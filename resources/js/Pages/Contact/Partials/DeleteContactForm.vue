<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {useForm, router, usePage} from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from "axios";

const form = useForm({});

const id = usePage().props.id;

const confirmingContactDeletion = ref(false);

const confirmContactDeletion = () => {
    confirmingContactDeletion.value = true;
};

const deleteContact = async () => {
    await axios.delete('/api/contacts/' + id)
        .then(response => {
            window.location.href = route('contact.index');
            closeModal();
        }).catch(err => {
            console.log(err);
        })
};

const closeModal = () => {
    confirmingContactDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Delete Contact</h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your contact is deleted, all of its resources and data will be permanently deleted. Before deleting
                your contact, please download any data or information that you wish to retain.
            </p>
        </header>

        <DangerButton @click="confirmContactDeletion">Delete Contact</DangerButton>

        <Modal :show="confirmingContactDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete your contact?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your contact is deleted, all of its resources and data will be permanently deleted. Please
                    to confirm you would like to permanently delete your contact.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteContact"
                    >
                        Delete Contact
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
