import lang from 'lang.js';
import Translation from '../lang/Translation';
import { getLocale } from  '../helpers';

export const Lang = new lang({
    messages: Translation,
    locale: getLocale(),
    fallback: 'ru'
});
