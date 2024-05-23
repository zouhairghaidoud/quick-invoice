<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Plus, Printer, Trash } from 'lucide-vue-next';
import PrimaryButton from '../Components/PrimaryButton.vue'
import InputError from '../Components/InputError.vue'
import { Save } from 'lucide-vue-next';
import { onBeforeUnmount, ref, watch } from 'vue';

const props = defineProps({
    invoice: {
        type: Object,
        required: true,
    },
    items: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    logo: props.invoice.logo,
    seller_company: props.invoice.seller_company,
    seller_address: props.invoice.seller_address,
    seller_zip: props.invoice.seller_zip,
    seller_city: props.invoice.seller_city,
    seller_state: props.invoice.seller_state,
    seller_country: props.invoice.seller_country,
    buyer_company: props.invoice.buyer_company,
    buyer_address: props.invoice.buyer_address,
    buyer_zip: props.invoice.buyer_zip,
    buyer_city: props.invoice.buyer_city,
    buyer_state: props.invoice.buyer_state,
    buyer_country: props.invoice.buyer_country,
    invoice_no: props.invoice.invoice_no,
    invoice_date: props.invoice.invoice_date,
    due_date: props.invoice.due_date,
    notes: props.invoice.notes,
    terms: props.invoice.terms,
    sub_total: props.invoice.sub_total,
    has_discount: props.invoice.has_discount,
    discount_type: props.invoice.discount_type,
    discount_value: props.invoice.discount_value,
    has_tax: props.invoice.has_tax,
    tax_type: props.invoice.tax_type,
    tax_value: props.invoice.tax_value,
    has_shipping: props.invoice.has_shipping,
    shipping_amount: props.invoice.shipping_amount,
    total_amount: props.invoice.total_amount,
    currency: props.invoice.currency,
    language: props.invoice.language,

    items: props.items,
});

const addItem = () => {
    form.items.push({
        item_name: 'Item name ' + (parseInt(form.items.length) + 1),
        description: '',
        quantity: 1,
        price: 10,
        sub_total: 10,
    });

    calculate();
}

const removeItem = (index) => {
    form.items.splice(index, 1);

    calculate();
}

const submit = () => {
    form.post(route('invoices.update', props.invoice.id), {
        onFinish: () => form.reset('password'),
    });
};

const setName = (event, index) => {
    const item_name = event.target.value;
    form.items[index].item_name = item_name;
}

const setDescription = (event, index) => {
    const description = event.target.value;
    form.items[index].description = description;
}

const setQty = (event, index) => {
    const quantity = event.target.value;
    form.items[index].quantity = quantity;

    const sub_total = form.items[index].quantity * form.items[index].price;
    form.items[index].sub_total = sub_total;

    calculate();
}

const setPrice = (event, index) => {
    const price = event.target.value;
    form.items[index].price = price;

    const sub_total = form.items[index].quantity * form.items[index].price;
    form.items[index].sub_total = sub_total;

    calculate();
}

const calculate = () => {
    form.sub_total = 0;
    form.items.forEach(item => {
        form.sub_total += parseFloat(item.sub_total);
    });


    form.total_amount = form.sub_total;
}

//////////////////
const previewLogo = ref(props.invoice.logo ?? null);
const logoInfo = ref('');

const handleLogoChange = (event) => {
    const file = event.target.files[0];
    form.logo = file;

    if (!file) {
        return;
    }

    // Validate file type and size (optional)
    if (!validateImage(file)) {
        return;
    }

    previewLogo.value = URL.createObjectURL(file);
    logoInfo.value = `File: ${file.name}, Size: ${(file.size / 1024).toFixed(2)}KB`;
}

function validateImage(file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/avif', 'image/svg'];
    const maxSize = 1024 * 1024; // 1MB limit (adjust as needed)

    if (!allowedTypes.includes(file.type)) {
        console.error('Invalid image type. Please select a JPEG, PNG, or GIF file.');
        return false;
    }

    if (file.size > maxSize) {
        console.error('Image size exceeds limit. Please select a file under 1MB.');
        return false;
    }

    return true;
}

onBeforeUnmount(() => {
    if (previewLogo.value) {
        URL.revokeObjectURL(previewLogo.value);
    }
});

</script>

<template>

    <Head title="Home" />

    <AuthenticatedLayout>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-4 gap-4" id="invoiceForm">
            <div class="col-span-3">
                <div
                    class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                    <div class="mb-5">
                        <label class="cursor-pointer d-inline-block w-[150px] h-[180px]">
                            <input type="file" id="imageFile" accept="image/*" ref="imageFileRef"
                                @change="handleLogoChange"
                                class="text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 hidden">
                            <div v-if="previewLogo" class="mt-3">
                                <img :src="previewLogo" alt="Preview" class="w-[150px] h-[180px] rounded-xl">
                                <p class="sr-only">{{ logoInfo }}</p>
                            </div>
                            <div v-else
                                class="w-[150px] h-[180px] rounded-xl border flex items-center justify-center text-gray-900 dark:text-white">
                                Logo Here
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                        <div class="flex flex-col gap-5">

                            <div class="text-gray-900 dark:text-white text-2xl font-bold">
                                Seller
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="seller_company"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.seller_company" type="text" id="seller_company"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Company" required />

                                    <InputError class="mt-2" :message="form.errors.seller_company" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="seller_address"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.seller_address" type="text" id="seller_address"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Address" required />

                                    <InputError class="mt-2" :message="form.errors.seller_address" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="seller_zip"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ZIP</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.seller_zip" type="text" id="seller_zip" placeholder="ZIP"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />

                                    <InputError class="mt-2" :message="form.errors.seller_zip" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="seller_city"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.seller_city" type="text" id="seller_city" placeholder="City"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />

                                    <InputError class="mt-2" :message="form.errors.seller_city" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="seller_state"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.seller_state" type="text" id="seller_state" placeholder="State"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />

                                    <InputError class="mt-2" :message="form.errors.seller_state" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="seller_country"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.seller_country" type="text" id="seller_country"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Country" required />

                                    <InputError class="mt-2" :message="form.errors.seller_country" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-5">

                            <div class="text-gray-900 dark:text-white text-2xl font-bold">
                                Buyer
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="buyer_company"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.buyer_company" type="text" id="buyer_company"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Company" required />

                                    <InputError class="mt-2" :message="form.errors.buyer_company" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="buyer_address"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.buyer_address" type="text" id="buyer_address"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Address" required />

                                    <InputError class="mt-2" :message="form.errors.buyer_address" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="buyer_zip"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ZIP</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.buyer_zip" type="text" id="buyer_zip" placeholder="ZIP"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />

                                    <InputError class="mt-2" :message="form.errors.buyer_zip" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="buyer_city"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.buyer_city" type="text" id="buyer_city" placeholder="City"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />

                                    <InputError class="mt-2" :message="form.errors.buyer_city" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="buyer_state"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.buyer_state" type="text" id="buyer_state" placeholder="State"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />

                                    <InputError class="mt-2" :message="form.errors.buyer_state" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="buyer_country"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.buyer_country" type="text" id="buyer_country"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Country" required />

                                    <InputError class="mt-2" :message="form.errors.buyer_country" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mt-20">
                        <div class="flex flex-col gap-5">

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="invoice_no"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                                        No.</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.invoice_no" type="text" id="invoice_no"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Invoice No." required />

                                    <InputError class="mt-2" :message="form.errors.invoice_no" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="invoice_date"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Invoice Date
                                    </label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.invoice_date" type="date" id="invoice_date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Invoice Date" required />

                                    <InputError class="mt-2" :message="form.errors.invoice_date" />
                                </div>
                            </div>

                            <div class="flex items-center gap-5">
                                <div class="w-[100px]">
                                    <label for="due_date"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Due</label>
                                </div>
                                <div class="grow">
                                    <input v-model="form.due_date" type="date" id="due_date" placeholder="Due"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />

                                    <InputError class="mt-2" :message="form.errors.due_date" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="relative overflow-x-auto mt-10">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-md">
                                <tr>
                                    <th scope="col" class="py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        Qty
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        Price
                                    </th>
                                    <th scope="col" class="px-2 py-3">
                                        Sub Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in form.items"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <!-- Description -->
                                    <td scope="row"
                                        class="py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white lg:w-[300px] xl:w-[400px]">
                                        <input @input="setName($event, index)" :value="item.item_name" type="text"
                                            placeholder="Item name"
                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required />

                                        <textarea @input="setDescription($event, index)" :value="item.description"
                                            type="text" rows="5"
                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-3"
                                            placeholder="Description" required></textarea>
                                    </td>
                                    <!-- Qty -->
                                    <td class="px-2 py-4 align-top">
                                        <input min="1" @input="setQty($event, index)" :value="item.quantity"
                                            type="number" placeholder="Qty" required
                                            class="w-[100px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    </td>
                                    <!-- Price -->
                                    <td class="px-2 py-4 align-top flex gap-2 items-center">
                                        <span class="text-gray-900 dark:text-white">{{ form.currency }}</span>
                                        <input min="0" @input="setPrice($event, index)" :value="item.price"
                                            type="number" placeholder="Price" required
                                            class="w-[100px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    </td>
                                    <!-- Sub Total -->
                                    <td class="px-2 py-4 align-top">
                                        <div class="flex gap-2 items-center justify-between">
                                            <div class="flex gap-2 items-center">
                                                <span class="text-gray-900 dark:text-white">{{ form.currency }}</span>
                                                <input :value="item.sub_total" type="number" placeholder="Sub Total"
                                                    required
                                                    class="w-[100px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    disabled />
                                            </div>

                                            <div class="flex gap-1">
                                                <button type="button" v-if="index == form.items.length - 1"
                                                    @click="addItem"
                                                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-full text-xs px-2 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                                    <Plus class="w-4 h-4" />
                                                </button>

                                                <button type="button" v-if="index !== 0" @click="removeItem(index)"
                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-full text-xs px-2 py-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                                    <Trash class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 gap-10 mt-20 border-t-2 border-gray-900 dark:border-white pt-5">

                        <div class="flex flex-col gap-5">

                            <div>
                                <div class="w-[100px]">
                                    <label for="notes"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                                </div>
                                <div class="grow">
                                    <textarea v-model="form.notes" type="text" id="notes" rows="6" placeholder="Notes"
                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-3"
                                        required></textarea>

                                    <InputError class="mt-2" :message="form.errors.notes" />
                                </div>
                            </div>

                            <div>
                                <div class="w-[100px]">
                                    <label for="terms"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Terms</label>
                                </div>
                                <div class="grow">
                                    <textarea v-model="form.terms" type="text" id="terms" rows="6" placeholder="Terms"
                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-3"
                                        required></textarea>

                                    <InputError class="mt-2" :message="form.errors.terms" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-5">

                            <div class="grid grid-cols-1 lg:grid-cols-3">

                                <label class="inline-flex items-center lg:flex-col gap-2 cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span
                                        class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Discount</span>
                                </label>

                                <label class="inline-flex items-center lg:flex-col gap-2 cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tax</span>
                                </label>

                                <label class="inline-flex items-center lg:flex-col gap-2 cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>
                                    <span
                                        class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Shipping</span>
                                </label>

                            </div>

                            <div class="flex justify-between text-gray-900 dark:text-white text-2xl">
                                <div>Sub Total</div>
                                <div>{{ form.currency }} {{ form.sub_total }}</div>
                            </div>

                            <div class="flex flex-col gap-5">

                                <div class="flex items-center gap-5">
                                    <div class="w-[100px]">
                                        <label for="discount_value"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                                    </div>
                                    <div class="grow flex items-center gap-3">
                                        <div class="text-gray-900 dark:text-white">{{ form.currency }}</div>
                                        <div class="grow">
                                            <input v-model="form.discount_value" type="number" id="discount_value"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Discount" required />
                                            <InputError class="mt-2" :message="form.errors.discount_value" />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-5">
                                    <div class="w-[100px]">
                                        <label for="tax_value"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax</label>
                                    </div>
                                    <div class="grow flex items-center gap-3">
                                        <div class="text-gray-900 dark:text-white">{{ form.currency }}</div>
                                        <div class="grow">
                                            <input v-model="form.tax_value" type="number" id="tax_value"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Tax" required />
                                            <InputError class="mt-2" :message="form.errors.tax_value" />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-5">
                                    <div class="w-[100px]">
                                        <label for="shipping_amount"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shipping</label>
                                    </div>
                                    <div class="grow flex items-center gap-3">
                                        <div class="text-gray-900 dark:text-white">{{ form.currency }}</div>
                                        <div class="grow">
                                            <input v-model="form.shipping_amount" type="number" id="shipping_amount"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Shipping" required />
                                            <InputError class="mt-2" :message="form.errors.shipping_amount" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex justify-between text-gray-900 dark:text-white text-2xl border-t-2 border-gray-900 dark:border-white pt-2">
                                <div>Total Amount</div>
                                <div>{{ form.currency }} {{ parseFloat(form.sub_total) +
                                    parseFloat(form.tax_value) + parseFloat(form.shipping_amount) -
                                    parseFloat(form.discount_value) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                <PrimaryButton class="w-full mt-2 flex justify-center items-center gap-2"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    <Save class="w-5 h-5" />
                    Save
                </PrimaryButton>

                <Link href="#"
                    class="w-full mt-2 flex justify-center items-center gap-2 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                <Printer class="w-5 h-5" />
                Print
                </Link>

                <div class="mt-3">
                    <label for="currency" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Currency
                    </label>
                    <select v-model="form.currency" id="currency"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="USD">USD</option>
                        <option value="MAD">MAD</option>
                    </select>
                </div>
            </div>
        </form>

    </AuthenticatedLayout>
</template>


<style>
#invoiceForm input[type="number"] {
    direction: rtl;
}
</style>
