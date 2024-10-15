<template>

    <div class="p-0 card">

        <publish-container
            name="assetdrop"
            :blueprint="blueprint"
            :values="values"
            :meta="meta"
            :errors="errors"
            @updated="values = $event"
        >
            <div slot-scope="{ setFieldValue, setFieldMeta }">
                <publish-fields
                    :fields="fields"
                    @updated="setFieldValue"
                    @meta-updated="setFieldMeta"
                />
            </div>
        </publish-container>

        <div class="publish-fields @container">
            <div class="form-group publish-field w-full">
                <large_assets-uploader
                    ref="uploader"
                    :enabled="ready"
                    :clear-successful="false"
                    :container="assetsField.config.container"
                    :path="assetsField.config.folder"
                    :values-resolver="uploadValues"
                    @updated="uploadsUpdated"
                    @upload-complete="uploadComplete"
                    @error="uploadError"
                >
                    <div slot-scope="{ dragging }">

                        <div class="tv2reg-assetdrop-zone" :class="{
                            'tv2reg-assetdrop-ready': ready,
                            'tv2reg-assetdrop-dragging': dragging,
                        }">
                            <template v-if="!uploads.length">
                                <div v-if="!dragging" class="tv2reg-assetdrop-status">
                                    <svg-icon name="upload" class="opacity-25" />
                                    <div class="mt-4">
                                        <button type="button" @click.prevent="uploadFile">
                                            {{ __('Upload files') }}
                                        </button>
                                        {{ __('or drag & drop here') }}
                                    </div>
                                </div>
                                <div v-if="dragging" class="tv2reg-assetdrop-status">
                                    <svg-icon name="upload" />
                                    <div class="mt-4">
                                        {{ __('Drop to Upload') }}
                                    </div>
                                </div>
                            </template>
                            <uploads
                                v-if="uploads.length"
                                :uploads="uploads"
                            />
                        </div>

                    </div>
                </large_assets-uploader>

            </div>
        </div>

    </div>

</template>

<script>
import Uploads from './Uploads.vue';

export default {

    components: {
        Uploads,
    },

    props: {
        blueprint: {
            type: Object,
            required: true,
        },
        initialValues: {
            type: Object,
            required: true,
        },
        initialMeta: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            values: this.initialValues,
            meta: this.initialMeta,
            errors: {},
            uploads: [],
        };
    },

    mounted() {
        this.$refs.uploader.initialize(
            this.assetsField.config,
            this.assetsField.meta,
        );
    },

    computed: {
        
        fields() {
            return this.blueprint.tabs[0].sections[0].fields.filter(field => field.handle !== 'assets');
        },
        
        assetsField() {
            return {
                config: this.blueprint.tabs[0].sections[0].fields.find(field => field.handle === 'assets'),
                meta: this.meta.assets,
            };
        },
        
        ready() {
            return this.values.name;
        },

    },

    methods: {

        uploadFile() {
            this.$refs.uploader.browse();
        },

        uploadValues(file, values) {
            const date = new Date().toISOString();
            return {
                ...values,
                assetdrop_name: this.values.name,
                assetdrop_uploaded_at: {
                    date: date.split('T')[0],
                    time: date.split('T')[1].split('.')[0],
                },
                assetdrop_uploaded_by: [Statamic.user.id],
            };
        },

        async uploadComplete(asset) {
            const url = cp_url(`assetdrop`);
            await this.$axios.post(url, {
                id: asset.id,
            });
        },

        uploadError(upload, uploads) {
            this.uploads = uploads;
            this.$toast.error(upload.errorMessage);
        },

        uploadsUpdated(uploads) {
            this.uploads = uploads;
        },

    }

}
</script>