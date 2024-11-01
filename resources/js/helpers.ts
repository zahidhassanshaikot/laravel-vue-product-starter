// import { iziToast } from "izitoast";

// initialize settings

import { isProxy, toRaw } from "vue";
import Translate from "./trans/translate_helper";
import axios from 'axios';
import * as _ from "lodash";

toastr.options = {
    timeOut: 5000,
    showDuration: 300,
    progressBar: true,
    icon: "material-icons",
    closeButton: true,
    showMethod: "fadeIn",
    positionClass: "toast-top-right",
};

interface Features {
    title?: string;
    zindex?: 999;
    message?: string;
    position?: string;
}

const notifyMe = (
    message: string = "",
    type: "info" | "success" | "warning" | "error" | "question" = "info",
    position: string = "toast-top-right"
): void => {
    if (message.length > 0) {
        toastr[type](message);
    }
};

const notifyErrors = (
    messages: Object | Array<any>,
    position: string = "toast-top-right"
): void => {
    for (const errorItem in messages) {
        const items = messages[errorItem];
        items.forEach((error) => {
            notifyMe(items, "error");
        });
    }
};

const proxyObjToPlainObj = (obj: {}) => {
    if (!obj && typeof obj === "undefined") {
        return obj;
    } else {
        if (isProxy(obj)) {
            return toRaw(obj);
        } else {
            return JSON.parse(JSON.stringify(obj));
        }
    }
};

const proxyObjToArray = (proxyObj: {}) => {
    const proxyData = proxyObjToPlainObj(proxyObj);

    const results = Object.keys(proxyData).map((key) => {
        return proxyData[key];
    });

    // return _.reverse(results);
    return results;
};

const findBy = (
    array: [],
    findByValue: number | string,
    findPropertyName: string = "id"
) => {
    if (typeof array === "undefined") {
        return array;
    }

    const proxyData = proxyObjToPlainObj(array);

    const results = Object.keys(proxyData).map((key) => {
        return proxyData[key];
    });

    // return _.find(results);
    const item = _.findIndex(results, function (obj) {
        return obj[findPropertyName] == findByValue;
    });
    return item;
};

const proxyObjToArrayWithReverse = (proxyObj: {}) => {
    const array = proxyObjToArray(proxyObj);
    return _.reverse(array);
};

const strLimit = (
    str: string,
    limitLength: number = 18,
    concatenate: string = "..."
) => {
    let output = "";
    if (str && str.length > limitLength) {
        output = `${str.substr(0, limitLength)}...`;
    } else {
        output = str;
    }
    return output;
};

let allLangData:any;

const  getTrans = (model: string, id?:number, locale?:'bn', field_name?:'string', defaultVal?:string|number|null) => {
    const trans = new Translate(model, locale, id, field_name, defaultVal);
    return trans.getTransData();
}

const initiateTranslate = async (model, locale)=>{
    let  id, field_name, defaultVal;
    const trans = new Translate(model, locale, id, field_name, defaultVal);
    return await trans.initializeTranslate();
}

const removeSessionTranslateData = (model=null, locale=null) => {
    let  id, field_name, defaultVal;
    const trans = new Translate(model, locale, id, field_name, defaultVal);
    return trans.clearSessionData();
}

export {
    notifyMe,
    proxyObjToPlainObj,
    proxyObjToArray,
    findBy,
    strLimit,
    proxyObjToArrayWithReverse,
    notifyErrors,
    getTrans,
    initiateTranslate,
    removeSessionTranslateData
};
