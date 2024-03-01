<script setup>
    import { Head } from '@inertiajs/vue3';
    import axios from 'axios';
    import Layout from '../Shared/Layout.vue';
    import Calculator from '../Shared/Calculator.vue';
    import PrevCalculations from '../Shared/PrevCalculations.vue';
    import { defineOptions, ref, nextTick } from 'vue';

    const calculationRef = ref('');
    const prevContainerRef = ref(null);

    const props = defineProps({
        calculations: {
            type: Array,
            default: () => [],
            validator: (calculations) => {
                return calculations.every(
                    (calculation) =>
                        typeof calculation.actual_calculation !== 'undefined',
                );
            },
        },
    });

    const handlePrevDeleteEvent = (id) => {
        axios
            .delete(`/calculations/${id}`)
            .then(() => {
                const index = props.calculations.findIndex((c) => c.id === id);

                if (index !== -1) {
                    props.calculations.splice(index, 1);
                }
            })
            .catch(() => {
                // TODO: Better UI to handle error or flashMessage
                console.error('Something bad happened');
            });
    };

    const handlePrevClickEvent = (calculation) => {
        calculationRef.value = calculation;
    };

    const handleSubmitCalculation = (calculation) => {
        axios
            .post('/calculation', { input: calculation })
            .then((response) => {
                const { data } = response.data;
                props.calculations.push(data);

                nextTick(() => {
                    const container = prevContainerRef.value;
                    if (container) {
                        const children = container.children;
                        const lastChild = children[children.length - 1];
                        if (lastChild) {
                            // Calculate the position of the lastChild relative to the container
                            const lastChildPosition =
                                lastChild.offsetTop + lastChild.clientHeight;
                            const containerHeight = container.clientHeight;

                            // Adjust the scrollTop of the container to scroll into view
                            container.scrollTop =
                                lastChildPosition - containerHeight;
                        }
                    }
                });
            })
            .catch((error) => {
                // TODO: Better UI to handle error or flashMessage
                console.error(error);
            });
    };

    defineOptions({
        layout: Layout,
    });
</script>

<template>
    <Head title="Calculator - Joseph Curtis" />
    <div>
        <div class="flex lg:h-dvh lg:p-0 p-2 h-100 items-center justify-center">
            <!-- <h1 class="col-span-12 max-w-1xl text-3xl font-bold tracking-tight text-gray-900 sm:text-2xl">Calculator</h1> -->
            <div class="lg:h-[600px] grid grid-cols-12 lg:gap-1.5 gap-4">
                <div
                    ref="prevContainerRef"
                    class="lg:col-span-4 h-[600px] col-span-12 overflow-y-auto rounded-lg lg:order-first order-last">
                    <PrevCalculations
                        @clickPrevEvent="handlePrevClickEvent"
                        @deletePrevEvent="handlePrevDeleteEvent"
                        :calculations="calculations" />
                </div>
                <div class="lg:col-span-8 col-span-12">
                    <Calculator
                        @submitCalculation="handleSubmitCalculation"
                        :prevInput="calculationRef" />
                </div>
            </div>
        </div>
    </div>
</template>
