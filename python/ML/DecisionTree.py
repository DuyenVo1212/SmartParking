import pandas as pd
from sklearn.tree import DecisionTreeRegressor
from sklearn.model_selection import train_test_split
from datetime import datetime

# Load the data from the 'reserved-list' table
data = pd.read_csv('F:/Xampp/htdocs/parking/ML/reserved-list.csv')

# Convert the 'restime' column to datetime format
data['restime'] = pd.to_datetime(data['restime'])

# Add columns for the year, month, day of week and hour
data['year'] = data['restime'].dt.year
data['month'] = data['restime'].dt.month
data['dayofweek'] = data['restime'].dt.dayofweek
data['hour'] = data['restime'].dt.hour

# Group the data by year, month, day of week and hour and count the number of entries
traffic_data = data.groupby(['year', 'month', 'dayofweek', 'hour']).count()['id'].reset_index()

# Sum the traffic for each month
monthly_traffic = traffic_data.groupby(['year', 'month'])['id'].sum().reset_index().rename(columns={'id': 'traffic'})

# Print the monthly traffic
print(monthly_traffic)

# Get this month's traffic
current_year = datetime.now().year
current_month = datetime.now().month
current_dayofweek = datetime.now().weekday()
current_hour = datetime.now().hour
current_traffic = traffic_data.loc[(traffic_data['year'] < current_year) | ((traffic_data['year'] == current_year) & (traffic_data['month'] < current_month)), 'id'].sum()

while True:
    # Get input for the month and year to predict
    while True:
        try:
            max_month = 12 if current_year < monthly_traffic['year'].max() else monthly_traffic['month'].max()
            max_year = current_year if max_month != 12 else current_year + 1
            month = int(input(f"Enter the month to predict (as a number, after month {max_month}): "))
            year = int(input(f"Enter the year for the prediction (after {max_year}): "))
            if (year < current_year) or (year == current_year and month <= current_month) or (month > 12):
                raise ValueError
            break
        except ValueError:
            print(f"Please enter a valid future month and year (after {current_month}/{current_year}), or a month between {current_month+1} and 12 in {current_year+1}")

    # Prepare data for training
    if year == current_year and month <= current_month:
        training_data = traffic_data.copy()
    elif year <= current_year:
        training_data = traffic_data[(traffic_data['year'] < year) | ((traffic_data['year'] == year) & (traffic_data['month'] < month))]
    else:
        training_data = traffic_data[(traffic_data['year'] < year) | ((traffic_data['year'] == year) & (traffic_data['month'] < month-1))]

    # Split the data into training and testing sets
    X_train, X_test, y_train, y_test = train_test_split(training_data[['year', 'month', 'dayofweek', 'hour']], training_data['id'], test_size=0.2)

    # Train the decision tree regressor
    model = DecisionTreeRegressor()
    model.fit(X_train, y_train)

    # Test the model
    score = model.score(X_test, y_test)
    # Print the score of the model
    print(f"The model score is {score}")

    # Predict the traffic for the given month and year"""prediction = model.predict([[year, month, current_dayofweek, current_hour]])[0] """

    prediction = model.predict(pd.DataFrame([[year, month, current_dayofweek, current_hour]], columns=['year', 'month', 'dayofweek', 'hour']))[0]
    # Print the predicted traffic
    print(f"The predicted traffic for {month}/{year} is {prediction}")

    """ # Ask the user if they want to make another prediction """
    """ while True: """
    """     try: """
    """         answer = input("Do you want to make another prediction? (y/n): ") """
    """         if answer not in ['y', 'n']: """
    """             raise ValueError """
    """         break """
    """     except ValueError: """
    """         print("Please enter 'y' or 'n'") """
    """  """
    """ # If the user does not want to make another prediction, break the loop """
    """ if answer == 'n': """
    """     break """
