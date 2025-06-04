@extends('layouts.front')

@section('content')
<div class="section-body">
    <h2 class="section-title">Syntax Converter Feature Guide</h2>
    <p class="section-lead">
        Learn about the different modes available in our Java to Python converter tool.
    </p>
    
    <div class="row">
        <div class="col-12 mb-4">
            <div class="hero bg-primary text-white">
                <div class="hero-inner">
                    <h2>Welcome to Syntax Converter!</h2>
                    <p class="lead">This guide explains the differences between Learning Mode and Professional Mode to help you choose the best option for your needs.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-graduation-cap mr-2"></i> Learning Mode</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <span class="badge badge-info p-2 mb-3" style="font-size: 1rem;">For Beginners</span>
                        <div class="mt-3">
                            <i class="fas fa-code text-info" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    
                    <h5 class="card-title">Supported Syntax</h5>
                    <p>Basic Java syntax elements for examples:</p>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item"><i class="fas fa-keyboard mr-2 text-info"></i> Input (Scanner)</li>
                        <li class="list-group-item"><i class="fas fa-font mr-2 text-info"></i> Variable declarations</li>
                        <li class="list-group-item"><i class="fas fa-code-branch mr-2 text-info"></i> If, else if, else</li>
                        <li class="list-group-item"><i class="fas fa-redo mr-2 text-info"></i> For loops, while loops</li>
                        <li class="list-group-item"><i class="fas fa-calculator mr-2 text-info"></i> Simple math operations</li>
                        <li class="list-group-item"><i class="fas fa-not-equal mr-2 text-info"></i> Boolean logic</li>
                        <li class="list-group-item"><i class="fas fa-greater-than-equal mr-2 text-info"></i> Operators</li>
                        <li class="list-group-item"><i class="fas fa-exchange-alt mr-2 text-info"></i> Switch-case</li>
                        <li class="list-group-item"><i class="fas fa-quote-right mr-2 text-info"></i> String manipulation</li>
                    </ul>
                    
                    <h5 class="card-title">Code Length</h5>
                    <div class="progress mb-3" data-height="25">
                        <div class="progress-bar bg-info" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">50 words max</div>
                    </div>
                    
                    <h5 class="card-title">Explanations</h5>
                    <div class="alert alert-light">
                        <i class="fas fa-info-circle mr-2 text-info"></i> Detailed line-by-line explanations with equivalent Java-Python syntax pairs
                    </div>
                    
                    <h5 class="card-title">Tips</h5>
                    <div class="alert alert-light">
                        <i class="fas fa-lightbulb mr-2 text-warning"></i> Provides interesting Python tips related to the converted code
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-code mr-2"></i> Professional Mode</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <span class="badge badge-primary p-2 mb-3" style="font-size: 1rem;">For Experienced Users</span>
                        <div class="mt-3">
                            <i class="fas fa-laptop-code text-primary" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    
                    <h5 class="card-title">Supported Syntax</h5>
                    <p>All Java syntax for examples:</p>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item"><i class="fas fa-check mr-2 text-primary"></i> All basic syntax (from Learning Mode)</li>
                        <li class="list-group-item"><i class="fas fa-cubes mr-2 text-primary"></i> Object-Oriented Programming</li>
                        <li class="list-group-item"><i class="fas fa-project-diagram mr-2 text-primary"></i> Classes and objects</li>
                        <li class="list-group-item"><i class="fas fa-sitemap mr-2 text-primary"></i> Inheritance</li>
                        <li class="list-group-item"><i class="fas fa-cogs mr-2 text-primary"></i> Interfaces</li>
                        <li class="list-group-item"><i class="fas fa-toolbox mr-2 text-primary"></i> Methods and constructors</li>
                        <li class="list-group-item"><i class="fas fa-shield-alt mr-2 text-primary"></i> Exception handling</li>
                        <li class="list-group-item"><i class="fas fa-table mr-2 text-primary"></i> Arrays and collections</li>
                        <li class="list-group-item"><i class="fas fa-table mr-2 text-primary"></i> Encapsulation</li>
                    </ul>
                    
                    <h5 class="card-title">Code Length</h5>
                    <div class="progress mb-3" data-height="25">
                        <div class="progress-bar bg-primary" role="progressbar" data-width="100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">200 words max</div>
                    </div>
                    
                    <h5 class="card-title">Explanations</h5>
                    <div class="alert alert-light">
                        <i class="fas fa-info-circle mr-2 text-primary"></i> Brief summary of the overall code conversion (maximum 40 words)
                    </div>
                    
                    <h5 class="card-title">Tips</h5>
                    <div class="alert alert-light">
                        <i class="fas fa-lightbulb mr-2 text-secondary"></i> No tips or interesting facts provided
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Mode Comparison</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Feature</th>
                                    <th class="text-center"><i class="fas fa-graduation-cap"></i> Learning Mode</th>
                                    <th class="text-center"><i class="fas fa-code"></i> Professional Mode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Target User</td>
                                    <td class="text-center">Beginners learning Python</td>
                                    <td class="text-center">Experienced programmers</td>
                                </tr>
                                <tr>
                                    <td>Syntax Support</td>
                                    <td class="text-center">Basic syntax only</td>
                                    <td class="text-center">All Java syntax including OOP</td>
                                </tr>
                                <tr>
                                    <td>Code Length</td>
                                    <td class="text-center">50 words maximum</td>
                                    <td class="text-center">200 words maximum</td>
                                </tr>
                                <tr>
                                    <td>Explanation Style</td>
                                    <td class="text-center">Detailed line-by-line with syntax mapping</td>
                                    <td class="text-center">Brief overall summary</td>
                                </tr>
                                <tr>
                                    <td>Learning Tips</td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke text-center">
                    <a href="{{ route('syntax-converter.index') }}" class="btn btn-lg btn-success">
                        <i class="fas fa-code"></i> Go to Syntax Converter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .progress {
        height: 25px;
    }
    .progress-bar {
        line-height: 25px;
        font-weight: bold;
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection
```
