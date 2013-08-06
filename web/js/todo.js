function TodoCtrl($scope, $http) {

    $scope.init = function(){

        $scope.todos = [];

        $http.get('http://localhost/todo/web/task').success(function(data) {
            angular.forEach(data, function(todo){
                $scope.todos.push(todo);
            });
        }).error(function (error) {});

    }

    $scope.init();

    $scope.addTodo = function() {
        $scope.todos.push({title:$scope.todoText,done:false});
        $scope.todoText = '';
    };

    $scope.remaining = function(){

        var count = 0;
        angular.forEach($scope.todos, function(todo) {
            count += todo.done ? 0 : 1;
        });
        return count;
    };

    $scope.archive = function() {
        var oldTodos = $scope.todos;
        $scope.todos = [];
        angular.forEach(oldTodos, function(todo) {
            if (!todo.done) $scope.todos.push(todo);
        });
    };

}