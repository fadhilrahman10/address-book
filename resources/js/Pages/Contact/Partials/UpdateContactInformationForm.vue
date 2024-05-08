<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import axios from "axios";
import {onMounted, reactive, ref} from "vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    id: {
        type: String,
    }
});

const contactId = usePage().props.id;
onMounted(() => {
    getContact();
})

const getContact = async () => {
    await axios.get('/api/contacts/' + contactId)
        .then(response => {
            form.name = response.data.data.name;
            form.phone = response.data.data.phone;
            form.address = response.data.data.address;
        })
}

const form = useForm({
    name: '',
    phone: '',
    address: '',
});

const updateContact = async () => {
    form.processing = true;
    form.recentlySuccessful = false;
    await axios.put('/api/contacts/' + contactId, {
        name: form.name,
        phone: form.phone,
        address: form.address,
    },{
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
    }).then(response => {
        console.log(response.data);
        form.recentlySuccessful = response.data.status;
    }).catch((error) => {
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

    form.processing = false;
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Contact Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your contact information.
            </p>
        </header>

        <form @submit.prevent="updateContact" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="phone" value="Phone" />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    autocomplete="phone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
