<template>

    <div
        class="flex items-center p-2 border-b border-gray-400 bg-gray-100"
        :class="{
            'text-red-500': status == 'error',
            'text-green-500': status == 'success',
        }"
    >

        <div class="mr-2 shrink-0 flex items-center">
            <loading-graphic v-if="status === 'uploading' || status === 'pending'" :inline="true" text="" />
            <svg v-if="status === 'success'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-green-500 h-4 w-4">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
            </svg>
            <svg v-if="status === 'error'"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="text-red-500 h-4 w-4">
                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
        </div>

        <div class="grow whitespace-nowrap overflow-hidden text-ellipsis mr-2">
            {{ basename }}
        </div>

        <div class="w-1/2 shrink-0 mr-2">
            <div v-if="running" class="bg-gray-400 h-4 rounded flex">
                <div class="bg-blue h-full rounded text-white text-center text-3xs px-1 overflow-hidden" :style="{ width: percent+'%' }">
                    {{ Math.round(percent)+'%' }}
                </div>
            </div>
            <div class="text-right" v-if="status === 'error'">
                {{ error }}
            </div>
        </div>
        
    </div>

</template>


<script>
export default {

    props: ['extension', 'basename', 'percent', 'error', 'running'],

    computed: {

        status() {
            if (this.error) {
                return 'error';
            }
            if (this.percent === 100) {
                if (this.running) {
                    return 'pending';
                } else {
                    return 'success';
                }
            }
            if (!this.running) {
                return 'paused';
            }
            return 'uploading';
        }

    },

}
</script>
