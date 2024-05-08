<script setup>
import {Head, router} from "@inertiajs/vue3";
import TableContact from "@/Components/TableContact.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted, reactive, ref} from "vue";
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";
import CreateContactForm from "@/Pages/Contact/Partials/CreateContactForm.vue";
import SearchContactForm from "@/Pages/Contact/Partials/SearchContactForm.vue";

const contacts = ref(null);
const currentPage = ref(1);

const next = () => {
    currentPage.value += 1;
    getContacts();
}

const prev = () => {
    currentPage.value -= 1;
    getContacts();
}

onMounted(() => {
    getContacts();
})

const keyword = ref('');

function searching(n) {
    keyword.value = n;
    getContacts();
}

function getContacts() {
    axios.get('/api/contacts/', {
        params: {
            size: 5,
            search: keyword.value,
            page: currentPage.value
        }
    })
        .then(response => {
            contacts.value = response.data.data;
            currentPage.value = response.data.meta.current_page;
        } );
}
</script>

<template>
    <Head title="Contact" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contact</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white">
                            <div>
                                <CreateContactForm @refresh-data="getContacts" />
                            </div>

                            <SearchContactForm @keywordChange="searching" />
                        </div>

                        <TableContact :contacts="contacts" />

                        <Pagination @next="next" @prev="prev" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
