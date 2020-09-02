import Vue from 'vue';

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString().toLowerCase().trim();
    return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('uppercase', function (value) {
    if (!value) return ''
    return value.toUpperCase();
})

Vue.filter('toIpa', function(value) {
    // return TextToIPA.lookup(value);
});