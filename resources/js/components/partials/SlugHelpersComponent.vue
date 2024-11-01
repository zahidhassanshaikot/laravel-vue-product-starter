<template>
    <div class="form-group">
        <label>{{ $t("Course title") }} <span class="error">*</span></label>
        <input
            type="text"
            name="title"
            class="form-control"
            :placeholder="$t('Course title')"
            required
        />
        <p v-if="errors && errors?.['title']" class="error">{{ errors?.["title"] }}</p>
    </div>
</template>
<script>
export default {};
</script>
<style></style>
