<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    invoice: {
        type: Object,
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
});

</script>

<template>

    <Head title="Home" />

    <AuthenticatedLayout>


        <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">


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
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Company" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="seller_address"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.seller_address" type="text" id="seller_address"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Address" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="seller_zip"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ZIP</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.seller_zip" type="text" id="seller_zip"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="ZIP" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="seller_city"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.seller_city" type="text" id="seller_city"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="City" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="seller_state"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.seller_state" type="text" id="seller_state"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="State" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="seller_country"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.seller_country" type="text" id="seller_country"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Country" required />
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
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Company" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="buyer_address"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.buyer_address" type="text" id="buyer_address"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Address" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="buyer_zip"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ZIP</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.buyer_zip" type="text" id="buyer_zip"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="ZIP" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="buyer_city"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.buyer_city" type="text" id="buyer_city"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="City" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="buyer_state"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.buyer_state" type="text" id="buyer_state"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="State" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="buyer_country"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.buyer_country" type="text" id="buyer_country"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Country" required />
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mt-20">
                <div class="flex flex-col gap-5">

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="invoice_no"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice No.</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.invoice_no" type="text" id="invoice_no"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Invoice No." required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="invoice_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Invoice
                                Date</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.invoice_date" type="text" id="invoice_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Invoice Date" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-5">
                        <div class="w-[100px]">
                            <label for="due_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Due</label>
                        </div>
                        <div class="grow">
                            <input v-model="form.due_date" type="text" id="due_date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Due" required />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mt-20">

                <div class="flex flex-col gap-5">

                    <div>
                        <div class="w-[100px]">
                            <label for="notes"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notes</label>
                        </div>
                        <div class="grow">
                            <textarea v-model="form.notes" type="text" id="notes" rows="5"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Notes" required></textarea>
                        </div>
                    </div>

                    <div>
                        <div class="w-[100px]">
                            <label for="terms"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Terms</label>
                        </div>
                        <div class="grow">
                            <textarea v-model="form.terms" type="text" id="terms" rows="5"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Terms" required></textarea>
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
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Discount</span>
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
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Shipping</span>
                        </label>

                    </div>

                    <div class="flex justify-between text-gray-900 dark:text-white text-2xl">
                        <div>Sub Total</div>
                        <div>MAD 1775</div>
                    </div>

                    <div class="flex flex-col gap-5">

                        <div class="flex items-center gap-5">
                            <div class="w-[100px]">
                                <label for="discount_value"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount</label>
                            </div>
                            <div class="grow">
                                <input v-model="form.discount_value" type="text" id="discount_value"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Discount" required />
                            </div>
                        </div>

                        <div class="flex items-center gap-5">
                            <div class="w-[100px]">
                                <label for="tax_value"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax</label>
                            </div>
                            <div class="grow">
                                <input v-model="form.tax_value" type="text" id="tax_value"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Tax" required />
                            </div>
                        </div>

                        <div class="flex items-center gap-5">
                            <div class="w-[100px]">
                                <label for="shipping_amount"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shipping</label>
                            </div>
                            <div class="grow">
                                <input v-model="form.shipping_amount" type="text" id="shipping_amount"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Shipping" required />
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex justify-between text-gray-900 dark:text-white text-2xl border-t-2 border-gray-900 dark:border-white pt-2">
                        <div>Total Amount</div>
                        <div>MAD 1775</div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
