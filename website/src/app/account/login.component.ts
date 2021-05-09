import { Component, OnInit, Renderer2 } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { first } from 'rxjs/operators';

//call account service and alert service
import { AccountService, AlertService } from '@app/services';
//template assign
@Component({ templateUrl: 'login.component.html' })
export class LoginComponent implements OnInit {
  // the value of car is not reassigned, so we can make it a const
  form: FormGroup;
  loading = false;
  submitted = false;

  constructor(
    private _renderer: Renderer2,
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private accountService: AccountService,
    private alertService: AlertService
  ) {}

  ngOnInit() {
    let script = this._renderer.createElement('script');
    script.defer = true;
    script.async = true;
    script.src = '';
    this._renderer.appendChild(document.body, script);

    this.form = this.formBuilder.group({
      email: ['', Validators.required],
      password: ['', Validators.required],
      recaptcha: [''],
    });
  }
  //site Kye string
  keyPlugin: string = '6Lfa-8oaAAAAABfXdgfhXqyCE537dEoRozfcyn7D';

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
    this.accountService
      .login(this.f.email.value, this.f.password.value)
      .pipe(first())
      .subscribe({
        next: () => {
          // get return url from query parameters or default to home page
          const returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
          this.router.navigateByUrl(returnUrl);
        },
        error: (error) => {
          console.log(error);
          this.alertService.error(error);
          this.loading = false;
        },
      });
  }
}
