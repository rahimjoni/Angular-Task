import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { first } from 'rxjs/operators';
import { AccountService, AlertService,EmployeeService } from '@app/services';
import {toFormData} from '@app/helpers/obj2fd';


@Component({
  selector: 'app-employee-add',
  templateUrl: './employee-add.component.html',
  styleUrls: ['./employee-add.component.less']
})
export class EmployeeAddComponent implements OnInit {

    form: FormGroup;
    loading = false;
    submitted = false;
    id: string;
    isAddMode: boolean;

    constructor(
        private formBuilder: FormBuilder,
        private route: ActivatedRoute,
        private router: Router,
        private employeeService: EmployeeService,
        private alertService: AlertService
    ) { }

  ngOnInit() {

        this.id = this.route.snapshot.params['id'];
        this.isAddMode = !this.id;

        this.form = this.formBuilder.group({
            name: ['', Validators.required],
            email: ['', Validators.required],
            mobile: ['', Validators.required],
            basic_salary: ['', Validators.required],
            house_rent: ['', Validators.required],
            medical: ['', Validators.required],
            tax: [0],
        });


        if (!this.isAddMode) {
            this.employeeService.getById(this.id)
            .pipe(first())
                .subscribe(x => {
                    this.form.patchValue(x);
            });
        }

    }

    // convenience getter for easy access to form fields
    get f() { return this.form.controls; }

    onSubmit() {
        this.submitted = true;

        // reset alerts on submit
        this.alertService.clear();

        // stop here if form is invalid
        if (this.form.invalid) {
            return;
        }

        this.loading = true;
        if (this.isAddMode) {
            this.createEmployee();
        } else {
            this.updateEmployee();
        }
    }


    private createEmployee() {
        var object = toFormData(this.form.value);
        this.employeeService.create(object)
            .pipe(first())
            .subscribe({
            next: () => {
                this.alertService.success('Employee added successfully', { keepAfterRouteChange: true });
                this.router.navigate(['../'], { relativeTo: this.route });
            },
                error: error => {
                console.log(error)
                this.alertService.error(error);
                this.loading = false;
            }
        });
    }

    private updateEmployee() {
    var object = toFormData(this.form.value);
    this.employeeService.update(this.id, object)
        .pipe(first())
        .subscribe({
        next: () => {
            this.alertService.success('Update successful', { keepAfterRouteChange: true });
            this.router.navigate(['../../'], { relativeTo: this.route });
        },
        error: error => {
            this.alertService.error(error);
            this.loading = false;
        }
    });
    }

}
