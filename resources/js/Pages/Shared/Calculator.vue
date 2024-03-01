<script setup>
    import {
        reactive,
        onMounted,
        onUnmounted,
        watchEffect,
        defineEmits,
        ref,
    } from 'vue';
    import * as math from 'mathjs';

    const calculatorState = reactive({
        input: '',
        loading: false,
        error: false,
        valid: false,
    });

    const activeButton = ref('');

    const buttons = [
        { value: 'enter', type: 'hidden' },
        { value: 'backspace', type: 'hidden' },

        { value: 'C', type: 'clear' },
        { value: '(' },
        { value: ')' },
        { value: '/', type: 'operator' },

        { value: '7' },
        { value: '8' },
        { value: '9' },
        { value: '*', type: 'operator' },

        { value: '4' },
        { value: '5' },
        { value: '6' },
        { value: '-', type: 'operator' },

        { value: '1' },
        { value: '2' },
        { value: '3' },
        { value: '+', type: 'operator' },

        { value: '0' },
        { value: '.', type: 'operator' },
        { value: '=', type: 'equals' },
    ];

    function updateDisplay(value) {
        if (value === 'C') {
            return (calculatorState.input = '');
        }

        if (value === 'backspace') {
            return (calculatorState.input = calculatorState.input.slice(0, -1));
        }

        if (value === '=') {
            try {
                if (math.evaluate(calculatorState.input)) {
                    calculatorState.error = false;
                    submitCalculation(
                        math.evaluate(calculatorState.input).toString(),
                    );
                    return (calculatorState.input = math
                        .evaluate(calculatorState.input)
                        .toString());
                }
            } catch {
                calculatorState.error = true;
                return (calculatorState.input = 'Error: NaN');
            }
        }

        if (value !== '=') {
            calculatorState.input += value;
        }
    }

    const handleKeyUpEvent = (ev) => {
        const button = buttons.find(
            (btn) => btn.value.toLowerCase() === ev.key.toLowerCase(),
        );

        let timeoutId = null;

        if (button) {
            if (ev.key.toLowerCase() === 'enter') {
                updateDisplay('=');
                activeButton.value = '=';
            } else {
                activeButton.value = button.value;
                updateDisplay(button.value);
            }

            if (timeoutId !== null) {
                clearTimeout(timeoutId);
                timeoutId = null;
            }

            timeoutId = setTimeout(() => {
                activeButton.value = '';
                timeoutId = null;
            }, 200);
        }
    };

    const props = defineProps({
        prevInput: {
            type: String,
        },
    });

    watchEffect(() => {
        calculatorState.input = props.prevInput;
    });

    const emit = defineEmits(['submitCalculation']);

    const submitCalculation = (calculation) => {
        emit('submitCalculation', calculation);
    };

    onMounted(() => {
        window.addEventListener('keyup', handleKeyUpEvent);
    });

    onUnmounted(() => {
        window.removeEventListener('keyup', handleKeyUpEvent);
    });
</script>

<template>
    <form @submit.prevent="">
        <div
            class="mx-auto overflow-hidden shadow-lg shadow-lg border rounded-lg px-5 pt-5 h-[600px]">
            <div>
                <input
                    type="text"
                    v-model="calculatorState.input"
                    class="p-5 block w-full mb-3 text-black text-right text-3xl"
                    disabled />
                <div class="grid grid-cols-4 gap-4">
                    <button
                        v-for="btn in buttons"
                        :key="btn.value"
                        @click="updateDisplay(btn.value)"
                        :class="{
                            'col-span-2': btn.value === '0',
                            'h-20': true,
                            [btn.type ?? 'number']: btn.type || 'number',
                            'transition-colors border-2 duration-400 border-2 border-gray-500':
                                activeButton === btn.value,
                            'rounded-full items-center justify-center shadow-lg border-2 hover:border-2 hover:border-gray-500 focus:outline-none': true,
                            'text-lg font-bold': true,
                        }">
                        {{
                            btn.value === 'C' && calculatorState.input === ''
                                ? 'AC'
                                : btn.value
                        }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
