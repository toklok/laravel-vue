<script setup>
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import Layout from '../Shared/Layout.vue'
import Calculator from '../Shared/Calculator.vue'
import PrevCalculations from '../Shared/PrevCalculations.vue'
import { defineOptions, ref } from 'vue'

const calculationRef = ref('');

const props = defineProps({
    calculations: {
        type: Array,
        default: () => [],
        validator: (calculations) => {
            return calculations.every(calculation =>
                typeof calculation.actual_calculation !== 'undefined'
            );
        }
    }
})

const handlePrevDeleteEvent = (id) => {
    axios.delete(`/calculations/${id}`)
        .then(() => {
            const index = props.calculations.findIndex(c => c.id === id);

            if (index !== -1) {
                props.calculations.splice(index, 1);
            }
        })
        .catch(() => {
            // TODO: Better UI to handle error or flashMessage
            console.error('Something bad happened');
        })
};

const handlePrevClickEvent = (calculation) => {
    calculationRef.value = calculation;
}

const handleSubmitCalculation = (calculation) => {
    axios.post('/calculation', { input: calculation })
        .then(response => {
            const { data } = response.data;
            props.calculations.push(data);
        })
        .catch(error => {
            // TODO: Add better error UI or flashMessage
            console.error(error);
        })
}

defineOptions({
    layout: Layout,
})
</script>

<template>
    <Head title="Calculator - Joseph Curtis" />
    <div>
        <div class="flex h-dvh items-center justify-center">
            <!-- <h1 class="col-span-12 max-w-1xl text-3xl font-bold tracking-tight text-gray-900 sm:text-2xl">Calculator</h1> -->
            <div class="h-[600px] grid grid-cols-12 gap-1.5">
                <div class="col-span-4 h-full overflow-y-auto max-h-screen rounded-lg">
                    <PrevCalculations @clickPrevEvent="handlePrevClickEvent" @deletePrevEvent="handlePrevDeleteEvent"
                        :calculations="calculations" />
                </div>
                <div class="col-span-8">
                    <Calculator @submitCalculation="handleSubmitCalculation" :prevInput="calculationRef" />
                </div>
            </div>
        </div>
    </div>
</template>