import { createI18n } from 'vue-i18n';

const response = await axios.get(route('locale.translations'));
const messages = await response.data || [];

const responseCurrentLocale = await axios.get(route('locale.current'));
const currentLocale = responseCurrentLocale.data || 'en';

const i18n = createI18n({
    legacy: false,
    globalInjection: true,
    locale: currentLocale, // set default locale
    fallbackLocale: currentLocale,
    messages
});

export default i18n;
