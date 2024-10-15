<template>

    <div class="text-xs w-full">
        <upload
            v-for="(upload, i) in uploads"
            :key="upload.id"
            :basename="upload.basename"
            :extension="upload.extension"
            :percent="upload.percent"
            :running="upload.running"
            :error="upload.errorMessage"
        />
    </div>

</template>


<script>
import Upload from './Upload.vue';

export default {

    props: ['uploads'],

    components: {
        Upload
    },

}
</script>
