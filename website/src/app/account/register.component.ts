import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { first } from 'rxjs/operators';

import { AccountService, AlertService } from '@app/services';
import { toFormData } from '@app/helpers/obj2fd';
import { MustMatch } from '../helpers/must-match.validator';

@Component({ templateUrl: 'register.component.html' })
export class RegisterComponent implements OnInit {

  form: FormGroup;
  loading = false;
  submitted = false;
  imageURL: string;

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private accountService: AccountService,
    private alertService: AlertService
  ) {}

  ngOnInit() {
    this.form = this.formBuilder.group(
      {
        name: ['', Validators.required],
        email: [
          '',
          [
            Validators.required, Validators.email, Validators.pattern('^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$'),
          ],
        ],
        mobile: ['', Validators.required],
        dob: [
          '',
          [
            Validators.required, Validators.pattern(/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/),
          ],
        ],
        image_file: [null],
        password: ['', [Validators.required, Validators.minLength(8)]],
        confirmPassword: ['', Validators.required],
      },
      {
        validator: MustMatch('password', 'confirmPassword'),
      }
    );
  }

  onFileSelect(event) {
    const file = (event.target as HTMLInputElement).files[0];
    this.form.patchValue({
      image_file: file,
    });
  }

  // convenience getter for easy access to form fields
  get f() {
    return this.form.controls;
  }

  onSubmit() {
    this.submitted = true;
    // reset alerts on submit
    this.alertService.clear();
    // stop here if form is invalid
    if (this.form.invalid) {
      return;
    }
    this.loading = true;
    var object = toFormData(this.form.value);

    this.accountService
      .register(object)
      .pipe(first())
      .subscribe({
        next: () => {
          this.alertService.success('Registration successfully done !!! Please login', {
            keepAfterRouteChange: true,
          });
          this.router.navigate(['../login'], { relativeTo: this.route });
        },
        error: (error) => {
          this.alertService.error(error);
          this.loading = false;
        },
      });
  }
}
