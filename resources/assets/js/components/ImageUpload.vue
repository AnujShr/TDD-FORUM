<template>
    <label for="upload" class="btn-sm btn-outline-danger">Change Avatar
        <input id ="upload" type="file" accept="image/*" @change="onChange" hidden>
    </label>
</template>
<script>
    export default{
        methods: {
            onChange(e){
                if (!e.target.files.length) return;
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = e => {
                    let src = e.target.result;
                    this.$emit('loaded', {src, file});
                };
            }
        }
    }
</script>