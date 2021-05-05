// GMNewton 1.00
//
//Function:  
//Notes:  <copied from NGD Wiki>
//        0 is the exact solver (default).
//                This is a one pass solver that calculates regular and frictional forces at the same time. Use this model if you require a high degree of accuracy in your simulation.
//        n ( > 0 ) is the linear solver
//               This is a complete iterative solver which peform n iterations per update. Increasing the number of iterations will improve accuracy at the cost of solver speed. Use this model if you require speed over accuracy in your simulation.
//
//        The adaptive friction model combined with the linear solver model make for the fastest possible configuration of the Newton solver. This setup is best for games. If you need the best realistic behavior, we recommend the use of the exact solver and exact friction model which are the defaults.
//
//Arguments:
//   Argument0 - dWorld
//   Argument1 - model
//call GmnSetSolverModel(dWorld,model);
//return: 
return external_call(global.__GmnSetSolverModel__,argument0,argument1);
