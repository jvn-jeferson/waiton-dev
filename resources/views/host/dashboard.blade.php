@extends('layouts.final')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Home</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Calendar Reminders box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Reminders</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <i class="fas fa-circle text-warning"></i>
              <span class="text-dark ">October 10, 2021</span><span class=""> - Payment of corporate tax, local tax and consumption tax</span>
            </li>
            <li class="list-group-item">
              <i class="fas fa-circle text-warning"></i>
              <span class="text-dark">September 10, 2021</span><span class=""> - Income tax withholding payment2021</span>
            </li>
            <li class="list-group-item">
              <i class="fas fa-circle text-warning"></i>
              <span class="text-dark">August 30, 2014</span><span class=""> - Interim payment of corporate tax, local tax, and consumption tax</span>
            </li>
          </ul>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

      <!-- To Accounting Office -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">To Accounting Office</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped table-hover mx-auto col-sm-12 text-center">
            <thead class="thead bg-primary">
              <th>DATE</th>
              <th>FILE NAME</th>
              <th>STATUS</th>
              <th>VIEWING DEADLINE</th>
            </thead>
            <tbody>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample.pdf</td>
                <td>Uploaded</td>
                <td>June 30, 2021</td>
              </tr>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample2.pdf</td>
                <td>Uploaded</td>
                <td>June 30, 2021</td>
              </tr>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample3.pdf</td>
                <td>Uploaded</td>
                <td>June 30, 2021</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>

      <!-- From Accounting Office -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">From Accounting Office</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped table-hover mx-auto col-sm-12 text-center">
            <thead class="thead bg-info">
              <th>DATE</th>
              <th>FILE NAME</th>
              <th>Remarks</th>
              <th>VIEWING DEADLINE</th>
            </thead>
            <tbody>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample.pdf</td>
                <td>Awaiting Confirmation</td>
                <td>June 30, 2021</td>
              </tr>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample2.pdf</td>
                <td></td>
                <td>June 30, 2021</td>
              </tr>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample3.pdf</td>
                <td>No Confirmation Request</td>
                <td>June 30, 2021</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>

      <!-- File Storage -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">File Storage</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped table-hover mx-auto col-sm-12 text-center">
            <thead class="thead bg-info">
              <th>DATE</th>
              <th>FILE NAME</th>
              <th>Storage</th>
            </thead>
            <tbody>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample.pdf</td>
                <td>Saved</td>
              </tr>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample2.pdf</td>
                <td>Saved</td>
              </tr>
              <tr>
                <td>May 31, 2021</td>
                <td class="text-info">sample3.pdf</td>
                <td>Saved</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>

    </section>
  </div>
  @endsection