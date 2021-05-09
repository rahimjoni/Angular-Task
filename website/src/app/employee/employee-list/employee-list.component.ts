import { Component, OnInit } from '@angular/core';
import {EmployeeService} from '@app/services/employee.service'
@Component({
  selector: 'app-employee-list',
  templateUrl: './employee-list.component.html',
  styleUrls: ['./employee-list.component.less']
})
export class EmployeeListComponent implements OnInit {

  constructor(private empService: EmployeeService) { }
    employeeList = null;
    ngOnInit() {
      this.empService.getAll()
        .subscribe(employee => {
            this.employeeList = employee
        });
    }

    deleteEmployee(id: string) {
        const user = this.employeeList.find(x => x.id === id);
        user.isDeleting = true;
        this.empService.delete(id)
            .subscribe(() => this.employeeList = this.employeeList.filter(x => x.id !== id));
    }

}
