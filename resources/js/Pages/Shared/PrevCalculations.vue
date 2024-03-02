<script setup>
    import { defineEmits } from 'vue';

    const props = defineProps({
        calculations: Array,
    });

    const emit = defineEmits(['deletePrevEvent', 'clickPrevEvent']);

    const useCalculation = (calculation) => {
        emit('clickPrevEvent', calculation);
    };
    const deleteCalculation = (id) => {
        emit('deletePrevEvent', id);
    };
</script>

<template>
    <transition-group
        name="list"
        tag="ul"
        class="col-span-4 grid gap-1.5"
        v-if="calculations && calculations.length > 0">
        <li
            @click="useCalculation(calculation.actual_calculation)"
            class="lg:w-[200px] w-100 card group cursor-pointer rounded-lg border bg-card text-card-foreground shadow-sm p-3 hover:bg-gray-100 relative"
            v-for="calculation in calculations"
            :key="calculation.name">
            <span class="p-3">
                <span class="grid gap-1.5 block">
                    <p class="text-lg font-semibold line-clamp-3">
                        {{ calculation.actual_calculation }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ calculation.inputs }}
                    </p>
                    <span
                        @click.stop="deleteCalculation(calculation.id)"
                        class="delete-button bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transform transition-colors duration-150 ease-in-out absolute bottom-4 right-4 opacity-0 hover:opacity-100 group-hover:opacity-100"
                        >Delete</span
                    >
                </span>
            </span>
        </li>
    </transition-group>
    <div v-else class="col-span-4 grid gap-1.5">
        <p class="font-bold tracking-tight text-gray-900 text-center">
            No Calculations Found
        </p>
    </div>
</template>

<style scoped>
    .list-enter-from {
        opacity: 0;
        transform: translateY(-20);
    }

    .list-enter-active,
    .list-leave-active {
        transition: all 0.5s ease;
    }

    .list-leave-to {
        opacity: 0;
        transform: translateY(15px);
    }
</style>
