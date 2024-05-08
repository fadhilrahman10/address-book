<script setup>
import {Link} from "@inertiajs/vue3";

defineProps(['contacts'])
</script>

<template>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b" v-for="contact in contacts">
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                    <div class="ps-3">
                        <div class="text-base font-semibold">{{ contact.name }}</div>
                    </div>
                </th>
                <td class="px-6 py-4">
                    {{ contact.phone }}
                </td>
                <td class="px-6 py-4">
                    {{ contact.address }}
                </td>
                <td class="px-6 py-4">
                    <Link
                        :href="route('contact.edit', contact.id)"
                        class="font-medium text-blue-600 hover:underline transition duration-150 ease-in-out"
                    >
                        Edit
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>

</template>

<style scoped>

</style>
