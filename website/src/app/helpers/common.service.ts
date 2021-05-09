import {Injectable} from '@angular/core';
import {FormGroup} from "@angular/forms";

@Injectable({
  providedIn: 'root'
})
export class CommonService {

  constructor() { }

  static setFieldAttributesForcefully(form: FormGroup){
    let inputAryVar = form.controls;
    for(let keyVar in inputAryVar) {
      inputAryVar[keyVar].markAsTouched();
      inputAryVar[keyVar].markAsDirty();
    }
  }

}