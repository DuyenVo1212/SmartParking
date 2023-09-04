import pandas as pd
from sklearn.linear_model import LinearRegression
from sklearn.model_selection import train_test_split
from datetime import datetime

# Load the data from the 'reserved-list' table
data = pd.read_csv('F:/Xampp/htdocs/parking/ZVTEST/reserved-list.csv')

# Convert the 'restime' column to datetime format
data['restime'] = pd.to_datetime(data['restime'])

# Add columns for the year, month, day of week and hour
data['year'] = data['restime'].dt.year
data['month'] = data['restime'].dt.month
data['dayofweek'] = data['restime'].dt.dayofweek
data['hour'] = data['restime'].dt.hour

# Group the data by year, month, day of week and hour and count the number of entries
traffic_data = data.groupby(['year', 'month', 'dayofweek', 'hour']).count()['id'].reset_index()

# Get this month's traffic
current_year = datetime.now().year
current_month = datetime.now().month
current_dayofweek = datetime.now().weekday()
current_hour = datetime.now().hour
current_month_traffic = traffic_data.loc[(traffic_data['year'] == current_year) & (traffic_data['month'] == current_month), 'id'].sum()
print('This month\'s traffic:', current_month_traffic)

# Get input for the month to predict
while True:
    try:
        max_month = traffic_data['month'].max()
        month = int(input("Enter the month to predict (as a number, after month " + str(max_month) + "): "))
        if month <= max_month or month > 12:
            raise ValueError
        break
    except ValueError:
        print("Please enter a valid future month (as a number between", max_month+1, "and 12)")

# Prepare data for training
training_data = traffic_data[traffic_data['month'] < month]

# Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(training_data[['year', 'month', 'dayofweek', 'hour']], training_data['id'], test_size=0.2)

# Train the linear regression model
model = LinearRegression()
model.fit(X_train, y_train)

# Test the model
score = model.score(X_test, y_test)
print('R-squared:', score)

#Predict traffic for the selected month
next_year = current_year if month > current_month else current_year + 1
next_month = month
next_dayofweek = current_dayofweek + 1
if next_dayofweek > 6:
    next_dayofweek = 0

next_hour = current_hour + 1
if next_hour > 23:
    next_hour = 0

# Get data for all previous months for prediction
prediction_data = traffic_data[(traffic_data['year'] < next_year) | ((traffic_data['year'] == next_year) & (traffic_data['month'] < next_month))]

#Predict traffic for the selected month using the trained model
prediction = model.predict(prediction_data[['year', 'month', 'dayofweek', 'hour']])

#Calculate the predicted traffic for the selected month
predicted_monthly_traffic = prediction.sum()

#Calculate the difference between this month's traffic and the predicted traffic for the selected month
difference = predicted_monthly_traffic - current_month_traffic

#Print the prediction and whether it increased or decreased compared to this month's traffic
if difference > 0:
    print("Predicted traffic for month", month, "is", int(predicted_monthly_traffic), "which is an increase of", int(difference))
elif difference < 0:
    print("Predicted traffic for month", month, "is", int(predicted_monthly_traffic), "which is a decrease of", int(abs(difference)))
else:
    print("Predicted traffic for month", month, "is the same as this month's traffic")