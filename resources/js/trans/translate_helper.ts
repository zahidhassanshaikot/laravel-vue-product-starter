import * as _ from "lodash";
import axios from 'axios';

interface dataPromise{
    status: any,
    success: any,
}

class Translate {
    isFetchComplete = false;
    allLangData:any = [];
    actionUrl:string = route('get_lang.data.by_model');
    locale = 'en';
    model:string;
    model_id:number|null;
    field_name:string|null;
    defaultData:string|number|null;
    resData:string|number|null;

    constructor(model, locale, id, field_name, defaultData) {
        this.model       = model;
        this.locale      = locale;
        this.model_id    = id;
        this.field_name  = field_name;
        this.defaultData = defaultData;
    }

    getTransData(){
        const transData = this.prepareAndGetData();
        return transData;
    }

    async initializeTranslate(){
        const transData = await this.getLangDataFromApi();
        return transData;
    }

    async getLangDataFromApi(){
        await this.getData();
        return true;
    }

    async getData(){
        const payloadData = {
            model : this.model,
            locale: this.locale,
        }
        let _this = this;
        return await axios.post(this.actionUrl, payloadData)
        .then(res => {
            const {status, message, data} = res?.data;
            if (status == 'success') {
                _this.allLangData = data;
                sessionStorage.setItem(`lang-${_this.model}-${this.locale}`, JSON.stringify(data));
                _this.isFetchComplete = true;
                return data;
            }
        });
    }


    prepareAndGetData():string|any{
        this.resData = this.defaultData;
        let data = {
            created_at: "",
            field_name: "",
            id        : 0,
            locale    : "",
            model_id  : 0,
            model_name: "",
            updated_at: "",
            value     : ""
        };
        let allData = this.getSessionData();
        if (this.isFetchComplete) {
            const searchParam =  { 'model_id': this.model_id, 'field_name': this.field_name };
            data = _.find(this.allLangData, searchParam);

            if (data?.value && data?.value?.length > 0) {
                this.resData = data?.value;
            }
        }
        return this.resData;
    }

    getSessionData(){
        const sessionData = sessionStorage.getItem(`lang-${this.model}-${this.locale}`);
        if (sessionData) {
            this.allLangData = JSON.parse(sessionData);
            this.isFetchComplete = true;
            return this.allLangData;
        }
    }

    clearSessionData(){
        sessionStorage.remove(`lang-${this.model}-${this.locale}`);
        sessionStorage.clear();
    }


}

export default Translate;